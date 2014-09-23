<?php

function createEmployeeID($id) {
    return (string) sprintf("%'010s", $id);

}
