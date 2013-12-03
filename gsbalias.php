<?php

// Default Values.
$defaults = array(
  'parent' => '@parent',
  'site' => '[site]',
  'uri' => '[uri]',
  'env' => '[env]',
  'root' => '/var/www/html/[site].[env]/docroot',
  'remote-host' => '[server].prod.hosting.acquia.com',
  'remote-user' => '[site]',
  'path-aliases' => array(
    '%drush-script' => 'drush5',
  ),
);

// Our D7 servers and environments.
$d7_servers = array(
  'staging-1530' => array('dev', 'dev2', 'sandbox'),
  'ded-2036' => array('test', 'test2'),
  'ded-1505' => array('loadtest'),
  'ded-1528' => array('prod'),
);

$d7_sites = array(
  'gsbpublic' => array(
    'servers' => $d7_servers,
  ),
  'gsbalumni' => array(
    'servers' => $d7_servers,
  ),
  'gsbmygsb' => array(
    'servers' => $d7_servers,
  ),
  'sford' => array(
    'servers' => $d7_servers,
  ),
);

// Our D6 servers and environments.
$d6_servers = array(
  'staging-960' => array('dev', 'dev2', 'sandbox', 'test'),
  'ded-1505' => array('loadtest'),
  'ded-789' => array('prod'),
);

$d6_sites = array(
  'csi' => array(
    'servers' => $d6_servers,
    'uri' => 'csi.gsb.stanford.edu',
    'site' => 'sfordgsb',
  ),
  'onegsb' => array(
    'servers' => $d6_servers,
    'site' => 'sfordgsb',
  ),
);

// Combine all our sites.
$sites = $d7_sites + $d6_sites;

// Get the parent.
$path_parts = explode('/', $filename);
$file = array_pop($path_parts);
$file_parts = explode('.', $file);
$parent = $file_parts[0];

// Build the aliases.
$uri = !empty($sites[$parent]['uri']) ? $sites[$parent]['uri'] : 'default';
$site = !empty($sites[$parent]['site']) ? $sites[$parent]['site'] : $parent;

foreach ($sites[$parent]['servers'] as $server => $environments) {
  foreach ($environments as $env) {
    if (strpos($alias, 'test') === 0) {
      $alias = str_replace('test', 'stage', $env);
    }
    $aliases[$alias] = str_replace(array('[site]', '[env]', '[server]', '[uri]'), array($site, $env, $server, $uri), $defaults);
  }
}
