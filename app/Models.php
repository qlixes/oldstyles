<?php

require_once './include/db_connect.php';
require_once './include/PassHash.php';

class Models extends DbConnect
{
  private $random_number = 12345;
  private $password;

  protected $data = array();
  protected $connector;
  protected $stmt;
  protected $insert_id;
  protected $formatDate = 'Y-m-d';
  protected $formatTimestamp = 'Y-m-d H:i:s';

  public $response = array();

  public function __construct()
  {
    parent::__construct();
    $this->connector = parent::connect();
    $this->password = new PassHash();
  }

  public function getPasswordHash()
  {
    return $this->password->hash($this->random_number);
  }

  protected function generateApiKey()
  {
      return md5(uniqid(rand(), true));
  }
}

class Asuransi
{
  private $id_asuransi;
  private $jenis_asuransi;

  public function setup($jenis_asuransi)
  {
    $this->$jenis_asuransi = $jenis_iuran;
  }

  public function setID($id_asuransi)
  {
    $this->id_asuransi = $id_asuransi;
  }

  private function isExists()
  {
    if (isset($this->jenis_asuransi)) {
      $this->stmt = $this->connector->prepare("select id_asuransi, jenis_asuransi from asuransi where jenis_asuransi = :jenis_iuran");
      $this->stmt->bindParam("jenis_iuran", $this->jenis_asuransi);
      $this->stmt->execute();
      $num_rows = $this->stmt->rowCount();
    }
    $this->stmt = null;
    return $num_rows > 0;
  }

  public function show()
  {
    $sql = "select id_asuransi, jenis_asuransi from asuransi";
    if (isset($this->jenis_asuransi)) {
      $sql .= " where jenis_asuransi like ':jenis_asuransi%'";
      $this->stmt = $this->connector->prepare($sql);
      $this->stmt->bindParam("jenis_asuransi", $this->jenis_asuransi);
    } else if (isset($this->id_asuransi)) {
      $sql .= " where id_asuransi = :id_asuransi";
      $this->stmt = $this->connector->prepare($sql);
      $this->stmt->bindParam("id_asuransi", $this->id_asuransi);
    } else {
      $this->stmt = $this->connector->prepare($sql);
    }
    $this->stmt->execute();
    $this->response = $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function save()
  {
    if (!$this->isExists()) {
      $this->$stmt = $this->connector->prepare("insert into asuransi(jenis_asuransi) values (:jenis_asuransi)");
      $this->stmt->bindParam("jenis_asuransi", $this->jenis_asuransi);
      try {
        $this->stmt->execute();
        $this->show();
    } catch (Exception $e) {
      $this->response = array(
        'messages' => $e->getMessage()
      );
    };
    } else {
      $this->response = array(
        'messages' => REQUEST_FAILED
      );
    }
    $this->stmt = null;
  }

  public function update()
  {
    if ($this->isExist()) {
      $this->stmt = $this->connector->prepare("update asuransi set jenis_asuransi = :jenis_asuransi where id_asuransi = :id_asuransi");
      $this->stmt->bindParam(":jenis_asuransi", $this->jenis_iuran);
      $this->stmt->bindParam(":id_asuransi", $this->id_iuran);
      try {
        $this->stmt->execute();
        $this->show();
      } catch (Exception $e) {
        $this->response = array(
          'messages' => $e->getMessage()
        );
      }
    }
  }
}

class Bidang
{
  private $id_bidang;
  private $bidang;

  public function setup($bidang)
  {
    $this->$bidang = $bidang;
  }

  public function setID($id_bidang)
  {
    $this->id_bidang = $id_bidang;
  }

  private function isExists()
  {
    if (isset($this->bidang)) {
      $this->stmt = $this->connector->prepare("select id_bidang, bidang from asuransi where bidang = :bidang");
      $this->stmt->bindParam("bidang", $this->bidang);
      $this->stmt->execute();
      $num_rows = $this->stmt->rowCount();
    }
    $this->stmt = null;
    return $num_rows > 0;
  }

  public function show()
  {
    $sql = "select id_bidang, bidang from bidang";
    if (isset($this->bidang)) {
      $sql .= " where bidang like ':bidang%'";
      $this->stmt = $this->connector->prepare($sql);
      $this->stmt->bindParam("bidang", $this->bidang);
    } else if (isset($this->id_bidang)) {
        $sql .= " where id_bidang = :id_bidang";
        $this->stmt = $this->connector->prepare($sql);
        $this->stmt->bindParam("id_bidang", $this->id_bidang);
    } else {
      $this->stmt = $this->connector->prepare($sql);
    }
    $this->stmt->execute();
    $this->response = $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function save()
  {
    if (!$this->isExists()) {
      $this->$stmt = $this->connector->prepare("insert into bidang(bidang) values (:bidang)");
      $this->stmt->bindParam("bidang", $this->bidang);
      try {
        $this->stmt->execute();
        $this->show();
    } catch (Exception $e) {
      $this->response = array(
        'messages' => $e->getMessage()
      );
    };
    } else {
      $this->response = array(
        'messages' => REQUEST_FAILED
      );
    }
    $this->stmt = null;
  }

  public function update()
  {
    if ($this->isExist()) {
      $this->stmt = $this->connector->prepare("update bidang set bidang = :bidang where id_bidang = :id_bidang");
      $this->stmt->bindParam(":bidang", $this->bidang);
      $this->stmt->bindParam(":id_bidang", $this->id_bidang);
      try {
        $this->stmt->execute();
        $this->show();
      } catch (Exception $e) {
        $this->response = array(
          'messages' => $e->getMessage()
        );
      }
    }
  }
}

class Wilayah extends Models
{
  private $id_wilayah;
  private $wilayah;

  public function setup($wilayah)
  {
    $this->wilayah = $wilayah;
  }

  public function setID($id_wilayah)
  {
    $this->id_wilayah = $id_wilayah;
  }

  private function isExists()
  {
    if (isset($this->jenis_asuransi)) {
      $this->stmt = $this->connector->prepare("select id_wilayah, wilayah from wilayh where wilayah = :wilayah");
      $this->stmt->bindParam("wilayah", $this->wilayah);
      $this->stmt->execute();
      $num_rows = $this->stmt->rowCount();
    }
    $this->stmt = null;
    return $num_rows > 0;
  }

  public function show()
  {
    $sql = "select id_wilayah, wilayah from wilayah";
    if (isset($this->wilayah)) {
      $sql .= " where wilayah like ':wilayah%'";
      $this->stmt = $this->connector->prepare($sql);
      $this->stmt->bindParam("wilayah", $this->wilayah);
    } else if (isset($this->id_wilayah)) {
      $sql .= " where wilayah = :id_wilayah";
      $this->stmt = $this->connector->prepare($sql);
      $this->stmt->bindParam("id_wilayah", $this->id_wilayah);
    } else {
      $this->stmt = $this->connector->prepare($sql);
    }
    $this->stmt->execute();
    $this->response = $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function save()
  {
    if (!$this->isExists()) {
      $this->$stmt = $this->connector->prepare("insert into wilayah(wilayah) values (:wilayah)");
      $this->stmt->bindParam("wilayah", $this->wilayah);
      try {
        $this->stmt->execute();
        $this->show();
    } catch (Exception $e) {
      $this->response = array(
        'messages' => $e->getMessage()
      );
    };
    } else {
      $this->response = array(
        'messages' => REQUEST_FAILED
      );
    }
    $this->stmt = null;
  }

  public function update()
  {
    if ($this->isExist()) {
      $this->stmt = $this->connector->prepare("update wilayah set wilayah = :wilayah where id_wilayah = :id_wilayah");
      $this->stmt->bindParam(":wilayah", $this->wilayah);
      $this->stmt->bindParam(":id_wilayah", $this->id_wilayah);
      try {
        $this->stmt->execute();
        $this->show();
      } catch (Exception $e) {
        $this->response = array(
          'messages' => $e->getMessage()
        );
      }
    }
  }
}

// class Chat
// {
//   private $chat_id;
//   private $chats;
//   private $chat_type;
//   private $fid_dokter;
//   private $fid_pasien;
//   private $created_at;
// }
//
// class Chat_history
// {
//   private $fid_chat;
//   private $since;
//   private $status;
// }
//
// class Chat_Receipt
// {
//   private $id;
//   private $fid_chat;
//   private $is_read;
// }

class Dokter
{
  private $id_dokter;
  private $nama;
  private $alamat;
  private $handphone;
  private $email;
  private $tanggal_join;
  private $jambuka;
  private $jamtutup;
  private $riwayat_pendidikan;
  private $foto;
  private $suratizin;
  private $longlat;
  private $fid_bidang;
}

class Diagnosa
{
  private $id_diagnosa;
  private $fid_dokter;
  private $fid_pasien;
  private $diagnosa;
  private $status;
  private $tgl_diagnosa;
}

class History extends Models
{
  private $id_history;
  private $tanggal;
  private $fid_pasien;
  private $fid_dokter;
  private $chat;
}

class Pasien extends Models
{
  private $id_pasien;
  private $nama;
  private $tgllahir;
  private $jeniskelamin;
  private $nohp;
  private $email;
  private $fid_asuransi;
  private $fid_wilayah;
  private $foto;
  private $tgl_join;
  private $alamat;

  private $asuransi;
  private $wilayah;

  public function __construct()
  {
    parent::__construct();
    $this->asuransi = new Asuransi();
    $this->wilayah = new Wilayah();
  }

  public function setID($id_pasien)
  {
    $this->id_pasien = $id_pasien;
  }

  public function setup($nama, $tgllahir, $jeniskelamin, $nohp, $email, $jenis_asuransi, $wilayah, $foto, $tgl_join, $alamat)
  {
    $this->$nama = $nama;
    $this->$tgllahir = $tgllahir;
    $this->$jeniskelamin = $jeniskelamin;
    $this->$nohp = $nohp;
    $this->$email = $email;
    $this->asuransi->setup($jenis_asuransi);
    $this->asuransi->search();
    $this->fid_asuransi = $this->asuransi->response['id'];
    $this->wilayah->setup($wilayah);
    $this->wilayah->search();
    $this->fid_wilayah = $this->wilayah->response['id'];
    $this->$foto = $foto; //menggunakan uploader, check if isset
    $this->$tgl_join = $tgl_join;
    $this->$alamat = $alamat;
  }

  public function show()
  {
    $sql = "select a.id_pasien, a.nama, a.tgllahir, a.jeniskelamin, a.nohp, a.email, a.foto, a.tgl_join, a.alamat, c.wilayah, b.jenis_asuransi from pasien a left join asuransi b on b.id_asuransi = a.fid_asuransi left join wilayah c on c.id_wilayah = a.fid_wilayah";
    if (isset($this->nama)) {
      $sql .= " where nama like ':nama%'";
      $this->stmt = $this->connector->prepare($sql);
      $this->stmt->bindParam("nama", $this->nama);
    } else if (isset($this->id_pasien)) {
        $sql .= " where id_pasien = :id_pasien";
        $this->stmt = $this->connector->prepare($sql);
        $this->stmt->bindParam("id_pasien", $this->id_pasien);
    } else {
      $this->stmt = $this->connector->prepare($sql);
    }
    $this->stmt->execute();
    $this->response = $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function isExist()
  {
    if (isset($this->nama)) {
      $this->stmt = $this->connector->prepare("select * from pasien where nama = :nama");
      $this->stmt->bindParam("nama", $this->nama);
    } else if (isset($this->email)){
        $this->stmt = $this->connector->prepare("select * from pasien where email = :email");
        $this->stmt->bindParam(":email", $this->email);
    } else if (isset($this->id_pasien)){
        $this->stmt = $this->connector->prepare("select * from pasien where id_pasien = :id_pasien");
        $this->stmt->bindParam(":id_pasien", $this->id_pasien);
    };
    $this->stmt->execute();
    $num_rows = $this->stmt->rowCount();
    $this->stmt = null;
    return $num_rows > 0;
  }

  public function save()
  {
    if (!$this->isExist()) {
      $this->stmt = $this->connector->prepare("insert into pasien(nama, tgllahir, jeniskelamin, nohp, email, fid_asuransi, fid_wilayah, foto, tgl_join, alamat) values (:nama, :tgllahir, :jeniskelamin, :nohp, :email, :fid_asuransi, :fid_wilayah, :foto, :tgl_join, :alamat)");
      $this->stmt->bindParam(":nama", $this->nama);
      $this->stmt->bindParam(":tgllahir", $this->tgllahir);
      $this->stmt->bindParam(":jeniskelamin", $this->jeniskelamin);
      $this->stmt->bindParam(":nohp", $this->nohp);
      $this->stmt->bindParam(":email", $this->email);
      $this->stmt->bindParam(":fid_asuransi", $this->fid_asuransi);
      $this->stmt->bindParam(":fid_wilayah", $this->fid_wilayah);
      $this->stmt->bindParam(":foto", $this->foto);
      $this->stmt->bindParam(":tgl_join", $this->tgl_join);
      $this->stmt->bindParam(":alamat", $this->alamat);
      try {
        $this->stmt->execute();
        $this->show();
      } catch (Exception $e) {
        $this->response = array(
          'messages' => $e->getMessage()
        );
      }
    } else {
      $this->response = array(
        'messages' => REQUEST_FAILED
      );
    }
    $this->stmt = null;
  }

  public function update()
  {
    if ($this->isExist()) {
      $this->stmt = $this->connector->prepare("update pasien set nama=:nama, tgllhari=:tgllahir, jeniskelamin=:jeniskelamin, nohp=:nohp, email=:email, fid_asuransi=:fid_asuransi, fid_wilayah=:fid_wilayah, foto=:foto, alamat=:alamat where id_pasien=:id_pasien");
      $this->stmt->bindParam(":nama", $this->nama);
      $this->stmt->bindParam(":tgllahir", $this->tgllahir);
      $this->stmt->bindParam(":jeniskelamin", $this->jeniskelamin);
      $this->stmt->bindParam(":nohp", $this->nohp);
      $this->stmt->bindParam(":email", $this->email);
      $this->stmt->bindParam(":fid_asuransi", $this->fid_asuransi);
      $this->stmt->bindParam(":fid_wilayah", $this->fid_wilayah);
      $this->stmt->bindParam(":foto", $this->foto);
      $this->stmt->bindParam(":alamat", $this->alamat);
      $this->stmt->bindParam(":id_pasien", $this->id_pasien);
      try {
        $this->stmt->execute();
        $this->show();
      } catch (Exception $e) {
        $this->response = array(
          'messages' => $e->getMessage()
        );
      }
    }
  }
}

class Penyakit
{
  private $id_penyakit;
  private $penyakit;
}

class RekamMedik extends Models
{
  private $id_rekammedik;
  private $fid_pasien;
  private $isi;
  private $tglupdate;

  public function setup($fid_pasien, $isi, $tglupdate)
  {
    $this->fid_pasien = $fid_pasien;
    $this->isi = $isi;
    $this->tglupdate = (isset($tglupdate)) ? $tglupdate : date($this->formatTimestamp);
  }

  public function setID($id_rekammedik)
  {
    $this->id_rekammedik = $id_rekammedik;
  }

  public function show()
  {
    $sql = "select id_rekammedik, fid_pasien, isi, tglupdate from asuransi";
    if (isset($this->fid_pasien)) {
      $sql .= " where fid_pasien = :fid_pasien";
      $this->stmt = $this->connector->prepare($sql);
      $this->stmt->bindParam("fid_pasien", $this->fid_pasien);
    } else if (isset($this->id_rekammedik)) {
      $sql .= " where id_rekammedik = :id_rekammedik";
      $this->stmt = $this->connector->prepare($sql);
      $this->stmt->bindParam("id_rekammedik", $this->id_rekammedik);
    } else {
      $this->stmt = $this->connector->prepare($sql);
    }
    $this->stmt->execute();
    $this->response = $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function save()
  {
    if (isset($this->fid_pasien)) {
      $this->$stmt = $this->connector->prepare("insert into rekammedik(fid_pasien, isi, tglupdate) values (:fid_pasien, isi, tglupdate)");
      $this->stmt->bindParam("fid_pasien", $this->fid_pasien);
      $this->stmt->bindParam("isi", $this->isi);
      $this->stmt->bindParam("tglupdate", $this->tglupdate);
      try {
        $this->stmt->execute();
        $this->show();
    } catch (Exception $e) {
      $this->response = array(
        'messages' => $e->getMessage()
      );
    };
    } else {
      $this->response = array(
        'messages' => REQUEST_FAILED
      );
    }
    $this->stmt = null;
  }

  public function update()
  {
    if ($this->isExist()) {
      $this->stmt = $this->connector->prepare("update rekammedik set isi = :isi, tglupdate = :tglupdate where fid_pasien = :fid_pasien and id_rekammedik = :id_rekammedik");
      $this->stmt->bindParam(":fid_pasien", $this->fid_pasien);
      $this->stmt->bindParam(":id_rekammedik", $this->id_rekammedik);
      try {
        $this->stmt->execute();
        $this->show();
      } catch (Exception $e) {
        $this->response = array(
          'messages' => $e->getMessage()
        );
      }
    }
  }
}

class Tindakan
{
  private $id_tindakan;
  private $fid_pasien;
  private $fid_dokter;
  private $tindakan;
  private $tgl_tindakan;
}

// class User
// {
//   private $id_user;
//   private $username;
//   private $password;
//   private $registration_id;
//   private $api;
//   private $otp;
//   private $akses;
//   private $fid_pasien;
//   private $fid_dokter;
// }
