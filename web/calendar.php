<?php

namespace MRBS;

use DateInterval;

require "defaultincludes.inc";
require_once "functions_ical.inc";

$sql = "SELECT E.*, "
  . db()->syntax_timestamp_to_unix("E.timestamp") . " AS last_updated, "
  . "A.area_name, A.sort_key AS area_sort_key, R.room_name, R.sort_key AS room_sort_key, R.area_id, "
  . "A.approval_enabled, A.confirmation_enabled, A.enable_periods";
$sql .= ", T.rep_type, T.end_date, T.rep_opt, T.rep_interval, T.month_absolute, T.month_relative ";
$sql .= "FROM mrbs_entry E";
$sql .= " LEFT JOIN " . _tbl('room') . " R
ON E.room_id=R.id";
$sql .= " LEFT JOIN " . _tbl('area') . " A
ON R.area_id=A.id";

$sql .= " LEFT JOIN " . _tbl('repeat') . " T
ON E.repeat_id=T.id";
$sql .= " WHERE E.start_time < UNIX_TIMESTAMP(NOW() + INTERVAL 3 MONTH) AND E.end_time > UNIX_TIMESTAMP(NOW() - INTERVAL 3 MONTH)";
$sql .= " AND A.enable_periods=0";
$sql_params = array();
if(isset($_GET['room']) && !empty($_GET['room'])) {
  $sql .= " AND (R.room_name = ? OR R.description = ?)";
  $sql_params[] = $_GET['room'];
  $sql_params[] = $_GET['room'];
}
$sql .= " ORDER BY repeat_id IS NULL DESC, repeat_id, ical_recur_id, timestamp, create_by";

$res = db()->query($sql, $sql_params);
header('Content-Type: text/calendar; charset=utf-8');
export_icalendar($res, FALSE);
