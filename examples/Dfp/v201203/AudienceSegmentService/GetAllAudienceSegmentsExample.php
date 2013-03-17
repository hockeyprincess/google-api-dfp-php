<?php
/**
 * This example gets all audience segments.
 *
 * Tags: AudienceSegmentService.getAudienceSegmentsByStatement
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
 * @subpackage v201203
 * @category   WebServices
 * @copyright  2012, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 * @author     Paul Rashidi
 */
error_reporting(E_STRICT | E_ALL);

// You can set the include path to src directory or reference
// DfpUser.php directly via require_once.
// $path = '/path/to/dfp_api_php_lib/src';
$path = dirname(__FILE__) . '/../../../../src';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';

try {
  // Get DfpUser from credentials in "../auth.ini"
  // relative to the DfpUser.php file's directory.
  $user = new DfpUser();

  // Log SOAP XML request and response.
  $user->LogDefaults();

  // Get the AudienceSegmentService.
  $audienceSegmentService = $user->GetService('AudienceSegmentService',
      'v201203');

  // Set defaults for page and statement.
  $page = new AudienceSegmentPage();
  $filterStatement = new Statement();
  $offset = 0;

  do {
    // Create a statement to get all audience segments.
    $filterStatement->query = 'LIMIT 500 OFFSET ' . $offset;

    // Get audience segments by statement.
    $page = $audienceSegmentService->getAudienceSegmentsByStatement(
        $filterStatement);

    // Display results.
    if (isset($page->results)) {
      $i = $page->startIndex;
      foreach ($page->results as $audienceSegment) {
        print $i . ') Audience segment with ID "'
            . $audienceSegment->id . '", and name "' . $audienceSegment->name
            . "\" was found.\n";
        $i++;
      }
    }

    $offset += 500;
  } while ($offset < $page->totalResultSetSize);

  print 'Number of results found: ' . $page->totalResultSetSize . "\n";
} catch (Exception $e) {
  print $e->getMessage() . "\n";
}
