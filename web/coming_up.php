<?php

namespace MRBS;

use IntlDateFormatter;

require "defaultincludes.inc";

echo '<html lang="de"><head><meta charset="utf-8" />';
require 'style.inc';
link('css/coming_up.css');
echo '</head><body>';

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
$sql .= " WHERE E.start_time > UNIX_TIMESTAMP(NOW()) AND E.end_time < UNIX_TIMESTAMP(NOW() + INTERVAL 3 MONTH)";
$sql .= " AND A.enable_periods=0";
$sql_params = array();
if(isset($_GET['room']) && !empty($_GET['room'])) {
  $sql .= " AND (R.room_name LIKE ? OR R.description = ?)";
  $sql_params[] = $_GET['room'];
  $sql_params[] = $_GET['room'];
}
if(isset($_GET['name']) && !empty($_GET['name'])) {
  $sql .= " AND (E.name = ?)";
  $sql_params[] = $_GET['name'];
}
$sql .= " ORDER BY start_time";
if(isset($_GET['max']) && !empty($_GET['max'])) {
  $sql .= " LIMIT " . intval($_GET['max']);
}

$res = db()->query($sql, $sql_params);

$fmt = datefmt_create(
  'de-DE',
  IntlDateFormatter::FULL,
  IntlDateFormatter::FULL,
  'Europe/Zurich',
  IntlDateFormatter::GREGORIAN,
  'EEEE, d. LLLL H'
);

if ($res->count() == 0) {
  echo '<ul><li>Zur Zeit sind keine Termine vorgesehen.</li></ul>';
}

echo '<ul>';
for ($i=0; (false !== ($row = $res->next_row_keyed())); $i++)
{
  //echo '<pre>'; print_r($row); echo '</pre>';
  echo '<li>';
  //echo '<strong>' . datefmt_format($fmt, $row['start_time']) . ' bis ' . gmdate('H:i', $row['end_time']) . '</strong> ' . $row['room_name'] . ' (' . $row['name'] . ')';
  echo '<strong>' . datefmt_format($fmt, $row['start_time']) . '&ensp;–&ensp;' . gmdate('H', $row['end_time']) . ' Uhr </strong> ' . $row['room_name'];
  echo '</li>';
}
echo '</ul>';

echo '</body></html>';
