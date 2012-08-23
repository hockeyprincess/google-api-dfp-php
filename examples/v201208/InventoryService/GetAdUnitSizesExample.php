<?php
/**
 * This example gets all web target platform ad unit sizes.
 *
 * Tags: InventoryService.getAdUnitSizes
 *
 * PHP version 5
 *
 * Copyright 2012, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsDfp
 * @subpackage v201208
 * @category   WebServices
 * @copyright  2012, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 * @author     Eric Koleda <api.ekoleda@gmail.com>
 * @author     Paul Rashidi <api.paulrashidi@gmail.com>
 */

error_reporting(E_STRICT | E_ALL);

// You can set the include path to src directory or reference
// DfpUser.php directly via require_once.
// $path = '/path/to/dfp_api_php_lib/src';
$path = dirname(__FILE__) . '/../../../src';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';

try {
  // Get DfpUser from credentials in "../auth.ini"
  // relative to the DfpUser.php file's directory.
  $user = new DfpUser();

  // Log SOAP XML request and response.
  $user->LogDefaults();

  // Get the InventoryService.
  $inventoryService = $user->GetService('InventoryService', 'v201208');

  // Create bind variables.
  $vars = MapUtils::GetMapEntries(
      array('targetPlatform' => new TextValue('WEB')));

  // Create a statement to only select web ad units sizes.
  $filterStatement = new Statement("WHERE targetPlatform = :targetPlatform ",
      $vars);

  // Get all ad unit sizes by statement.
  $page = $inventoryService->getAdUnitSizesByStatement($filterStatement);

  // Display results.
  if (isset($page->results)) {
    foreach ($page->results as $adUnitSize) {
      printf("Web ad unit size of dimensions %d x %d was found.\n",
          $adUnitSize->size->width,
          $adUnitSize->size->height);
    }
  } else {
    print "No ad unit sizes found.\n";
  }
} catch (Exception $e) {
  print $e->getMessage() . "\n";
}