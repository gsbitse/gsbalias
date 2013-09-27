<?php
// We only need aliases the first time through.
if (stristr($aliasname, '.')) {
  // Default Values
  $defaults = array(
    'parent' => '@parent',
    'site' => '[site]',
    'env' => '[env]',
    'root' => '/var/www/html/[site].[env]/docroot',
    'remote-host' => '[server].prod.hosting.acquia.com',
    'remote-user' => '[site]',
    'path-aliases' => array(
      '%drush-script' => 'drush5',
    ),
  );

  // Our D7 servers and environments
  $d7_sites = array('gsbpublic', 'gsbalumni', 'gsbmygsb', 'sford');
  $d7_servers = array(
    'staging-1530' => array('dev', 'dev2', 'sandbox'),
    'ded-2036' => array('test', 'test2'),
    'ded-1505' => array('loadtest'),
    'ded-1528' => array('prod'),
  );
  $d7_sites = array_fill_keys($d7_sites, $d7_servers);

  // Combine all our sites.
  $sites = $d7_sites;

  // Split on the alias.
  list($site, $alias) = explode('.', $aliasname);
  // Build the aliases
  foreach ($sites[$site] as $server => $environments) {
    foreach($environments as $env) {
      $alias = str_replace('test', 'stage', $env);
      $aliases[$alias] = str_replace(array('[site]', '[env]', '[server]'), array($site, $env, $server), $defaults);
    }
  }
}

