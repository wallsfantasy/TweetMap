<?php

require 'recipe/symfony3.php';

serverList('servers.yml');
env('branch', 'deploy');
set('default_stage', 'production');
set('repository', 'git@github.com:wallsfantasy/TweetMap.git');
