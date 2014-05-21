<?php

require 'vendor/autoload.php';
require 'config.php';

use Aws\Common\Aws;
use Aws\S3\Exception\S3Exception;

$aws = Aws::factory([
	'key' => $key,
	'secret' => $secret,
]);
$s3 = $aws->get('s3');

if (isset($_GET['key'])) {
	header('Location: ' . $s3->getObjectUrl($bucket, $_GET['key']));
}

$iterator = $s3->getIterator('ListObjects', array(
    'Bucket' => $bucket,
));

foreach ($iterator as $object) {
	$filename = $object['Key'];
	$ts = substr($filename, 0, strpos($filename, '.'));

	echo '<a href="index.php?key=' . $filename . '">' . date('d.m.Y H:i:s', $ts) . '</a><br>';
}
