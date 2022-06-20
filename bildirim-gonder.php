<?php
if ($_POST) {
    require 'inc/config.php';

    /** tokenlar */
    $tokenlar    = DB::get("SELECT * FROM tokenlar");
    $token_array = array();
    foreach ($tokenlar as $k => $v) {
        $token_array[] = $v->token;
    }

    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    $notification = [
        'title'        => $_POST['baslik'],
        'body'         => $_POST['aciklama'],
        'icon'         => 'default',
        'sound'        => 'default',
        'click_action' => $_POST['url'],
    ];

    $extraNotificationData = ["message" => $notification, "moredata" => ""];

    /** veriler */
    $fcmNotification = [
        'registration_ids' => $token_array,
        'notification'     => $notification,
        'data'             => $extraNotificationData,
    ];

    $headers = [
        'Authorization: key=<SERVER KEY>',
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fcmUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    $result = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result);
    header("Location:bildirim-gonder.php?success=" . $result->success);
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        form {

            width: 500px;
            margin: 0 auto;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <div class="container">
        <form action="" method="POST">
            
            <?php if ($_GET['success']) : ?>
                <div class="alert alert-success">
                    Başarıyla <?php echo $_GET['success'] ?> kişiye gönderildi.
                </div>
            <?php endif; ?>


            <div class="form-group">
                <label for="exampleInputEmail1">Başlık</label>
                <input type="text" name="baslik" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Açıklama</label>
                <input type="text" name="aciklama" class="form-control" required>
            </div>

            <div class="form-group">
                <label>URL</label>
                <input type="text" name="url" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Gönder</button>
        </form>
    </div>
</body>

</html>