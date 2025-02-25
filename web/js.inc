<?php
namespace MRBS;


function script($src, $add_version=false)
{
  echo '<script src="';
  $value = ($add_version) ? add_version($src) : $src;
  echo htmlspecialchars($value);
  echo "\"></script>\n";
}


global $view, $year, $month, $day, $area, $room;
global $multisite, $site;
global $debug;
global $custom_js_url;

$page = this_page(false, '.php');

// We need to construct a standard query string that can be passed to the *.js.php
// pages.  That's because some of the settings they use are area dependent.
// We also want the area to be in the query string so that the JavaScript page is
// cached if the area is the same and not otherwise.
$query_string = "area=$area";

if ($multisite && isset($site) && ($site !== ''))
{
  $query_string .= '&site=' . urlencode($site);
}

// Load the init file now so that it gets executed as soon as possible.  The init
// file can't use jQuery.
script('js/init.js.php', true);

script(($debug) ? 'jquery/jquery-3.7.0.js' : 'jquery/jquery-3.7.0.min.js');

// We need the migration script now that we are running jQuery 3.0+, or at least
// until we are confident that our JavaScript is not using any features that have
// been removed.   The uncompressed version will output warnings about removed and
// deprecated features to the console
script(($debug) ? 'jquery/jquery-migrate-3.4.0.js' : 'jquery/jquery-migrate-3.4.0.min.js');

// We are using the jQuery UI library, which has been custom-built to include the following components:
//   - Core
//      - as defined by dependencies in order to support the required interactions and widgets
//      - no need for jQuery 1.8 support
//
//   - Interactions
//      - Draggable
//      - Resizable
//
//   - Widgets
//      - Autocomplete
//      - Button
//      - Dialog
//      - Menu
//      - Mouse
//      - Tabs
//
//   - Cupertino theme
// If you need any other components you will need to rebuild the custom UI library
// See http://jqueryui.com/
script(($debug) ? 'jquery/ui/jquery-ui.js' : 'jquery/ui/jquery-ui.min.js', true);

// All pages
script("js/functions.js.php?$query_string", true);
script("js/general.js.php?$query_string", true);


script("js/flatpickr/flatpickr.min.js", true);
$datepicker_src = "js/datepicker.js.php?$query_string";
$flatpickr_lang_path = get_flatpickr_lang_path();
if (isset($flatpickr_lang_path))
{
  // Add the localisation file
  script($flatpickr_lang_path, true);
  // And give the datepicker file a query string parameter to force the browser cache
  // to be flushed when the language changes.
  $datepicker_src .= '&lang=' . urlencode(get_flatpickr_property($flatpickr_lang_path));
}
script($datepicker_src, true);

script("jquery/select2/dist/js/select2.full.min.js", true);

if (null !== ($select2_lang_path = get_select2_lang_path()))
{
  script($select2_lang_path, true);
}

// dataTables initialisation
if (in_array($page, array('admin', 'edit_users', 'pending', 'report', 'search', 'view_entry')))
{
  // Include the JavaScript for those pages that use dataTables
  // When constructing the DataTables download we want to include the following:
  //    DataTables styling framework
  //    DataTables package
  //    Buttons, and all sub-options
  //    ColReorder
  //    FixedColumns
  script(($debug) ? 'jquery/datatables/datatables.js' : 'jquery/datatables/datatables.min.js', true);
  script('jquery/datatables/plugins.js', true);
  script("js/datatables.js.php?$query_string", true);
}

// Get any page specific JavaScript
if (is_readable("js/$page.js"))
{
  script("js/$page.js?$query_string", true);
}
if (is_readable("js/$page.js.php"))
{
  script("js/$page.js.php?$query_string", true);
}

// The day, week and month views do refresh by Ajax.
// We need the resizable bookings for the day and week views
if ($page == 'index')
{
  script("js/refresh.js.php?$query_string", true);
  script("js/resizable.js.php?$query_string", true);
}

if (isset($custom_js_url))
{
  script($custom_js_url, true);
}
