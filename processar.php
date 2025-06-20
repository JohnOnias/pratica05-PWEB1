<?php
session_start();

$uploadDir = 'uploads/';
$allowedTypes = ['image/jpeg', 'image/png', 'image/tiff', 'image/gif'];
$allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'tiff'];
$maxFileSize = 2 * 1024 * 1024; 

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Acesso inválido ao script.');
}

$requiredFields = ['nome', 'email', 'senha', 'foto_perfil'];
$errors = [];

foreach ($requiredFields as $field) {
    if ($field !== 'foto_perfil' && empty($_POST[$field])) {
        $errors[] = "O campo " . ucfirst($field) . " é obrigatório.";
    }
}

if (isset($_FILES['foto_perfil'])) {
    $file = $_FILES['foto_perfil'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        switch ($file['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $errors[] = "O arquivo é muito grande. Tamanho máximo permitido: 2MB.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $errors[] = "O upload do arquivo foi interrompido.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $errors[] = "Nenhum arquivo foi enviado.";
                break;
            default:
                $errors[] = "Erro desconhecido durante o upload.";
        }
    } else {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, $allowedTypes)) {
            $errors[] = "Formato de arquivo não permitido. Use JPG, JPEG, PNG, TIFF ou GIF.";
        }

        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExt, $allowedExtensions)) {
            $errors[] = "Extensão de arquivo não permitida.";
        }

        if ($file['size'] > $maxFileSize) {
            $errors[] = "O arquivo é muito grande. Tamanho máximo permitido: 2MB.";
        }

        $imageInfo = @getimagesize($file['tmp_name']);
        if (!$imageInfo) {
            $errors[] = "O arquivo enviado não é uma imagem válida.";
        }
    }
} else {
    $errors[] = "Nenhum arquivo de imagem foi enviado.";
}

if (!empty($errors)) {
    $_SESSION['erros'] = $errors;
    header('Location: formulario_cadastro.php');
    exit;
}

$nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$newFileName = uniqid('profile_') . '.' . $fileExt;
$uploadPath = $uploadDir . $newFileName;

if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
    die("Falha ao salvar a imagem de perfil.");
}

$_SESSION['usuario'] = [
    'nome' => $nome,
    'email' => $email,
    'foto' => $uploadPath
];

header('Location: resultado.php');
exit;
?>
