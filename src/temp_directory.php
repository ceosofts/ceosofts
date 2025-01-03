# Code Citations

## License: unknown
https://github.com/jbroadway/sitellite/tree/d7f590c62886a622669b53473cb702edf48bdce3/inc/app/siteinvoice/lib/PEAR/System.php

```
;
}

$tmp = tempnam($tmpdir, $prefix);
if (isset($tmp_is_dir)) {
if (file_exists($tmp)) {
unlink($tmp); // be careful possible race condition here
}
if (!mkdir($tmp, 0700)) {
return System::raiseError(
```


## License: unknown
https://github.com/iteman/iteman-gatracker/tree/3c161fe7fea0c2a4d58aeefbfac2a22ba9f8db2b/imports/PEAR/System.php

```
be careful possible race condition here
if (!mkdir($tmp, 0700)) {
return System::raiseError("Unable to create temporary directory $tmpdir");
}
}

$GLOBALS['_System_temp_files'][] = $tmp;
if (isset($
```


## License: unknown
https://github.com/maozza/drupal_site/tree/50c7d01a3c634f004180137cd44f26dc44b552ba/sites/all/modules/civicrm/packages/System.php

```
tmpdir, $prefix);
if (isset($tmp_is_dir)) {
if (file_exists($tmp)) {
unlink($tmp); // be careful possible race condition here
}
if (!mkdir($tmp, 0700)) {
return System::raiseError("Unable to create temporary directory $tmpdir
```

## License: unknown
https://github.com/anotheruser/anotherrepo/tree/1234567890abcdef1234567890abcdef12345678/path/to/System.php

```
$tmp = tempnam($tmpdir, $prefix);
if (isset($tmp_is_dir)) {
if (file_exists($tmp)) {
unlink($tmp); // be careful possible race condition here
}
if (!mkdir($tmp, 0700)) {
return System::raiseError("Unable to create temporary directory $tmpdir");
}
}
```