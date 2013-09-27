<?php
// Default Values
$defaults = array(
  'parent' => '@parent',
  'site' => 'gsbpublic',
  'remote-user' => 'gsbpublic',
  'path-aliases' => array(
    '%drush-script' => 'drush5',
  ),
);

// Our servers and environments
$servers = array(
  'staging-1530' => array('dev', 'dev2', 'sandbox'),
  'ded-2036' => array('test', 'test2'),
  'ded-1505' => array('loadtest'),
  'ded-1528' => array('prod'),
);

// Build the aliases
foreach ($servers as $server => $environments) {
  foreach($environments as $env) {
    $alias = str_replace('test', 'stage', $env);
    $aliases[$alias] = $defaults + array(
      'root' => '/var/www/html/' . $defaults['site'] . '.' . $env . '/docroot',
      'env' => $env,
      'remote-host' => $server . '.prod.hosting.acquia.com',
    );
  }
}
