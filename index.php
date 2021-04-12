<?php
/**
 * Main index file
 */
include 'Application.php';
$config = require __DIR__ . '/config.php';
$app = new Application($config);
$result = $app->getResult();
?>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<h1>List of successful referrals of <b><?= $config['referral'] ?></b> from referrer <b><?= $config['referer'] ?></b>
    <br>
    <br>
<?php if ($result) { ?>
    <table class="table">
        <tr>
            <th>Client Id</th>
            <th>Fist visit</th>
            <th>Fist visit from referer</th>
            <th>Success date</th>
            <th>Ref. link</th>
        </tr>
        <?php foreach ($result as $item) { ?>
            <?php if (isset($item['success_date'])) { ?>
                <tr>
                    <td><?= $item['client_id'] ?></td>
                    <td><?= $item['first_visit'] ?></td>
                    <td><?= $item['first_ref_visit'] ?></td>
                    <td><?= $item['success_date'] ?></td>
                    <td><?= $item['ref_link'] ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>
<?php } ?>
</body>