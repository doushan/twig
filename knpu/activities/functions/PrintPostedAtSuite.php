<?php

use KnpU\ActivityRunner\Assert\AssertSuite;

use KnpU\ActivityRunner\Result;

class PrintPostedAtSuite extends AssertSuite
{
    public function runTest(Result $resultSummary)
    {
        $input = $resultSummary->getInput();

        // Look for `|date` without caring about spaces.
        $this->assertRegExp('#\|\s*date#', $input,
            'Using the |date filter to convert the date into a string.'
        );

        $this->assertRegexp('#Y-m-d#', $input,
            'It looks like you have the date filter, but the date isn\'t the right format. Make sure you\'re passing "Y-m-d" (with dashes) to the |date filter.'
        );

        // Now check that things are in the right spot.
        $postedAts = $this->getCrawler($resultSummary->getOutput())->filter('.posted-at');

        $this->assertEquals(1, count($postedAts), 'Did you forget to render the date inside an element with a "posted-at" class?');
        $this->assertRegexp("/2013-06-05/", $postedAts->text());
    }
}
