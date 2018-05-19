<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
// GET SEMUA
$app->get("/books/", function (Request $request, Response $response){
    $sql = "SELECT * FROM books";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});
$app->get("/users/", function (Request $request, Response $response){
    $sql = "SELECT * FROM users";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});
$app->get("/loaning/", function (Request $request, Response $response){
    $sql = "SELECT * FROM loaning";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});
// GET BERDASARKAN ID
$app->get("/books/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "SELECT * FROM books WHERE id_buku=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetch();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});
$app->get("/users/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "SELECT * FROM users WHERE id_user=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetch();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});
$app->get("/loaning/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "SELECT * FROM loaning WHERE id_loaning=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetch();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//POST
$app->post("/books/", function (Request $request, Response $response){

    $new_book = $request->getParsedBody();

    $sql = "INSERT INTO books (kode_buku, judul_buku, pengarang, gambar, info) VALUE (:kode_buku, :judul_buku, :pengarang, :gambar, :info)";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":kode_buku" => $new_book["kode_buku"],
        ":judul_buku" => $new_book["judul_buku"],
        ":pengarang" => $new_book["pengarang"],
        ":gambar" => $new_book["gambar"],
        ":info" => $new_book["info"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);

    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});
$app->post("/users/", function (Request $request, Response $response){

    $new_user = $request->getParsedBody();

    $sql = "INSERT INTO users (email, password, nama_lengkap, username, nomor_hp, pp) VALUE (:email, :password, :nama_lengkap, :username, :nomor_hp, :pp)";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":email" => $new_user["email"],
        ":password" => $new_user["password"],
        ":nama_lengkap" => $new_user["nama_lengkap"],
        ":username" => $new_user["username"],
        ":nomor_hp" => $new_user["nomor_hp"],
        ":pp" => $new_user["pp"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);

    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});
$app->post("/loaning/", function (Request $request, Response $response){

    $new_loan = $request->getParsedBody();

    $sql = "INSERT INTO loaning (id_user, id_buku, tanggal_pinjam, tanggal_kembali, status_pengembalian) VALUE (:id_user, :id_buku, :tanggal_pinjam, :tanggal_kembali, :status_pengembalian)";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":id_user" => $new_loan["id_user"],
        ":id_buku" => $new_loan["id_buku"],
        ":tanggal_pinjam" => $new_loan["tanggal_pinjam"],
        ":tanggal_kembali" => $new_loan["tanggal_kembali"],
        ":status_pengembalian" => $new_loan["status_pengembalian"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);

    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});

//UPDATE BERDASARKAN ID
$app->put("/books/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $new_book = $request->getParsedBody();
    $sql = "UPDATE books SET kode_buku=:kode_buku, judul_buku=:judul_buku, pengarang=:pengarang, gambar=:gambar, info=:info WHERE id_buku=:id";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":id" => $id,
        ":kode_buku" => $new_book["kode_buku"],
        ":judul_buku" => $new_book["judul_buku"],
        ":pengarang" => $new_book["pengarang"],
        ":gambar" => $new_book["gambar"],
        ":info" => $new_book["info"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);

    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});
$app->put("/users/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $new_user = $request->getParsedBody();
    $sql = "UPDATE users SET email=:email, password=:password, nama_lengkap=:nama_lengkap, username=:username, nomor_hp=:nomor_hp, pp=:pp WHERE id_user=:id";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":id" => $id,
        ":email" => $new_user["email"],
        ":password" => $new_user["password"],
        ":nama_lengkap" => $new_user["nama_lengkap"],
        ":username" => $new_user["username"],
        ":nomor_hp" => $new_user["nomor_hp"],
        ":pp" => $new_user["pp"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);

    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});
$app->put("/loaning/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $new_loan = $request->getParsedBody();
    $sql = "UPDATE loaning SET id_user=:id_user, id_buku=:id_buku, tanggal_pinjam=:tanggal_pinjam, tanggal_kembali=:tanggal_kembali, status_pengembalian=:status_pengembalianp WHERE id_loaning=:id";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":id" => $id,
        ":id_user" => $new_loan["id_user"],
        ":id_buku" => $new_loan["id_buku"],
        ":tanggal_pinjam" => $new_loan["tanggal_pinjam"],
        ":tanggal_kembali" => $new_loan["tanggal_kembali"],
        ":status_pengembalian" => $new_loan["status_pengembalian"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);

    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});
//DELETE BERDASARKAN ID
$app->delete("/books/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "DELETE FROM books WHERE id_buku=:id";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":id" => $id
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);

    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});
$app->delete("/users/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "DELETE FROM users WHERE id_user=:id";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":id" => $id
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);

    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});
$app->delete("/loaning/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "DELETE FROM loaning WHERE id_loaning=:id";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":id" => $id
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);

    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});
