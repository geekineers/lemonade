<?php

function createEmployeeID($id) {
    return (string) COMPANY_ID . sprintf("%'05s", $id);

}
