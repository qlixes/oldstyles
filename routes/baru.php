<?php

require "./app/Models.php";

$app->container->singleton('Pasien', function() {
  return new Pasien();
});

$app->container->singleton('RekamMedik', function() {
  return new RekamMedik();
});

$app->group('/pasien', function () use ($app) {
  $app->get('/', function() use ($app) {
    $app->Pasien->show();
    $app->response->write(json_encode($app->Pasien->response));
  });

  $app->get('/:id_pasien', function($id_pasien) use ($app) {
    $app->Pasien->setID($id_pasien);
    $app->Pasien->show();
    $app->response->write(json_encode($app->Pasien->response));
  });
  //input menggunakan body dlm bentuk json
  $app->post('/', function () use ($app) {
    $body = json_decode($app->request->getBody()); $tgl_join = $body['tgl_join'];
    $nama = $body['nama']; $email = $body['email']; $alamat = $body['alamat'];
    $tgllahir = $body['tgllahir']; $jenis_asuransi= $body['jenis_asuransi'];
    $jeniskelamin = $body['jeniskelamin']; $wilayah = $body['wilayah'];
    $nohp = $body['nohp']; $foto = $body['foto'];
    $app->Pasien->setup($nama, $tgllahir, $jeniskelamin, $nohp, $email, $jenis_asuransi, $wilayah, $foto, $tgl_join, $alamat);
    $app->Pasien->save();
  });
});
