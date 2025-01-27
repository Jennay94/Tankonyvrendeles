<?php
include('session_check.php');

header('Content-Type: application/json; charset=utf-8');





if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = 'aa';
    return $data;

    if (!isset($data))
        echo json_encode(['status' => 'success', 'receivedData' => 'Nincs ilyen végpont']);
    exit;

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_GET['hospital'] == 'AddPatient') {
        $data = AddPatients();
        return;
    }

    if ($_GET['hospital'] == 'AddPatientStatus') {
        $data = AddPatientStatus();
        return;
    }

    if (!isset($data))
        echo json_encode(['status' => 'success', 'receivedData' => 'Nincs ilyen végpont']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    if ($_GET['hospital'] == 'ModDiagnostic') {
        $data = ModDiagnostic();
        return;
    }
    /* */
    if (!isset($data))
        echo json_encode(['status' => 'success', 'receivedData' => 'Nincs ilyen végpont']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_GET['hospital'] == 'GetPatients') {
        $data = GetPatients();
        return;
    }
    /* */
    if (!isset($data))
        echo json_encode(['status' => 'success', 'receivedData' => 'Nincs ilyen végpont']);
    exit;
}

?>