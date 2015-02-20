<?php

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/../params.php");

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;

$params = new Params(__DIR__ . "/..");
$request = Request::createFromGlobals();
$pathinfo = pathinfo($request->getPathInfo());

if (!(preg_match('/^[a-zA-Z1-9-_\/]+$/', $pathinfo['dirname']) && isset($pathinfo['extension'])
    && in_array(strtolower($pathinfo['extension']), array('ttf', 'otf', 'eot', 'woff', 'woff2', 'svg')))
) {
    $response = new Response();
    $response->setContent("error");
    $response->headers->set("Content-Type", "text/html");
    $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    $response->setCharset('UTF-8');
    $response->prepare($request);
    $response->send();
    exit();
}

$fontpath = $params->getFontsDir() . $pathinfo['dirname'] . '/' . $pathinfo['basename'];
if (!file_exists($fontpath)) {
    $response = new Response();
    $response->setContent("font not found");
    $response->headers->set("Content-Type", "text/html");
    $response->setStatusCode(Response::HTTP_NOT_FOUND);
    $response->setCharset('UTF-8');
    $response->prepare($request);
    $response->send();
    exit();
}

$response = new BinaryFileResponse($fontpath);
$response->trustXSendfileTypeHeader();
$response->setStatusCode(Response::HTTP_OK);
$response->headers->set('Access-Control-Allow-Origin', '*');

switch ($pathinfo['extension']) {
    case 'ttf':
        $response->headers->set("Content-Type", "font/truetype");
        break;
    case 'otf':
        $response->headers->set("Content-Type", "font/opentype");
        break;
    case 'eot':
        $response->headers->set("Content-Type", "application/vnd.ms-fontobject");
        break;
    case 'woff':
        $response->headers->set("Content-Type", "font/woff");
        break;
    case 'woff2':
        $response->headers->set("Content-Type", "font/woff");
        break;
    case 'svg':
        $response->headers->set("Content-Type", "image/svg+xml");
        break;
    default:
        $response->headers->set("Content-Type", "application/octet-stream");
}

$response->setContentDisposition(
    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
    $pathinfo['basename']
);

$response->sendContent();
$response->prepare($request);
$response->send();
