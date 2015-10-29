<?php
// Call Net_LDAP2_SearchTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "Net_LDAP2_SearchTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'Net/LDAP2.php';
require_once 'Net/LDAP2/Search.php';

/**
 * Test class for Net_LDAP2_Search.
 * Generated by PHPUnit_Util_Skeleton on 2007-10-09 at 10:46:51.
 */
class Net_LDAP2_SearchTest extends PHPUnit_Framework_TestCase {
    /**
    * Stores the LDAP configuration
    */
    var $ldapcfg = false;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("Net_LDAP2_SearchTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
        $this->ldapcfg = $this->getTestConfig();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    }

    /**
     * This checks if a valid LDAP testconfig is present and loads it.
     *
     * If so, it is loaded and returned as array. If not, false is returned.
     *
     * @return false|array
     */
    public function getTestConfig() {
        $config = false;
        $file = dirname(__FILE__).'/ldapconfig.ini';
        if (file_exists($file) && is_readable($file)) {
            $config = parse_ini_file($file, true);
        } else {
            return false;
        }
        // validate ini
        $v_error = $file.' is probably invalid. Did you quoted values correctly?';
        $this->assertTrue(array_key_exists('global', $config), $v_error);
        $this->assertTrue(array_key_exists('test', $config), $v_error);
        $this->assertEquals(7, count($config['global']), $v_error);
        $this->assertEquals(7, count($config['test']), $v_error);

        // reformat things a bit, for convinience
        $config['global']['server_binddn'] =
            $config['global']['server_binddn'].','.$config['global']['server_base_dn'];
        $config['test']['existing_attrmv'] = explode('|', $config['test']['existing_attrmv']);
        return $config;
    }

    /**
    * Establishes a working connection
    *
    * @return Net_LDAP2
    */
    public function &connect() {
        // Check extension
        if (true !== Net_LDAP2::checkLDAPExtension()) {
            $this->markTestSkipped('PHP LDAP extension not found or not loadable. Skipped Test.');
        }

        // Simple working connect and privilegued bind
        $lcfg = array(
                'host'   => $this->ldapcfg['global']['server_address'],
                'port'   => $this->ldapcfg['global']['server_port'],
                'basedn' => $this->ldapcfg['global']['server_base_dn'],
                'binddn' => $this->ldapcfg['global']['server_binddn'],
                'bindpw' => $this->ldapcfg['global']['server_bindpw'],
                'filter' => '(ou=*)',
            );
        $ldap = Net_LDAP2::connect($lcfg);
        $this->assertInstanceOf('Net_LDAP2', $ldap, 'Connect failed but was supposed to work. Check credentials and host address. If those are correct, file a bug!');
        return $ldap;
    }

    /**
     * @todo Implement testEntries().
     */
    public function testEntries() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testShiftEntry().
     */
    public function testShiftEntry() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testShift_entry().
     */
    public function testShift_entry() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testPopEntry().
     */
    public function testPopEntry() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testPop_entry().
     */
    public function testPop_entry() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testSorted_as_struct().
     */
    public function testSorted_as_struct() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testSorted().
     */
    public function testSorted() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testAs_struct().
     */
    public function testAs_struct() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testSetSearch().
     */
    public function testSetSearch() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testSetLink().
     */
    public function testSetLink() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testCount().
     */
    public function testCount() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testGetErrorCode().
     */
    public function testGetErrorCode() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement test_Net_LDAP2_Search().
     */
    public function test_Net_LDAP2_Search() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testDone().
     */
    public function testDone() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement test_searchedAttrs().
     */
    public function test_searchedAttrs() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
    * tests SPL iterator
    */
    public function testSPLIterator() {
        if (!$this->ldapcfg) {
            $this->markTestSkipped('No ldapconfig.ini found. Skipping test!');
        } else {
            $ldap = $this->connect();

            // some testdata, so we have some entries to search for
            $base = $this->ldapcfg['global']['server_base_dn'];
            $ou1  = Net_LDAP2_Entry::createFresh('ou=Net_LDAP2_Test_search1,'.$base,
                array(
                    'objectClass' => array('top','organizationalUnit'),
                    'ou' => 'Net_LDAP2_Test_search1'
                ));
            $ou2  = Net_LDAP2_Entry::createFresh('ou=Net_LDAP2_Test_search2,'.$base,
                array(
                    'objectClass' => array('top','organizationalUnit'),
                    'ou' => 'Net_LDAP2_Test_search2'
                ));
            $this->assertTrue($ldap->add($ou1));
            $this->assertTrue($ldap->dnExists($ou1->dn()));
            $this->assertTrue($ldap->add($ou2));
            $this->assertTrue($ldap->dnExists($ou2->dn()));

            /*
            * search and test each method
            */
            $search = $ldap->search(null, '(ou=Net_LDAP2*)');
            $this->assertInstanceOf('Net_LDAP2_Search', $search);
            $this->assertEquals(2, $search->count());

            // current() is supposed to return first valid element
            $e1 = $search->current();
            $this->assertInstanceOf('Net_LDAP2_Entry', $e1);
            $this->assertEquals($e1->dn(), $search->key());
            $this->assertTrue($search->valid());

            // shift to next entry
            $search->next();
            $e2 = $search->current();
            $this->assertInstanceOf('Net_LDAP2_Entry', $e2);
            $this->assertEquals($e2->dn(), $search->key());
            $this->assertTrue($search->valid());

            // shift to non existent third entry
            $search->next();
            $this->assertFalse($search->current());
            $this->assertFalse($search->key());
            $this->assertFalse($search->valid());

            // rewind and test,
            // which should return the first entry a second time
            $search->rewind();
            $e1_1 = $search->current();
            $this->assertInstanceOf('Net_LDAP2_Entry', $e1_1);
            $this->assertEquals($e1_1->dn(), $search->key());
            $this->assertTrue($search->valid());
            $this->assertEquals($e1->dn(), $e1_1->dn());

            // Dont rewind but call current, should return first entry again
            $e1_2 = $search->current();
            $this->assertInstanceOf('Net_LDAP2_Entry', $e1_2);
            $this->assertEquals($e1_2->dn(), $search->key());
            $this->assertTrue($search->valid());
            $this->assertEquals($e1->dn(), $e1_2->dn());

            // rewind again and test,
            // which should return the first entry a third time
            $search->rewind();
            $e1_3 = $search->current();
            $this->assertInstanceOf('Net_LDAP2_Entry', $e1_3);
            $this->assertEquals($e1_3->dn(), $search->key());
            $this->assertTrue($search->valid());
            $this->assertEquals($e1->dn(), $e1_3->dn());

            /*
            * Try methods on empty search result
            */
            $search = $ldap->search(null, '(ou=Net_LDAP2Test_NotExistentEntry)');
            $this->assertInstanceOf('Net_LDAP2_Search', $search);
            $this->assertEquals(0, $search->count());
            $this->assertFalse($search->current());
            $this->assertFalse($search->key());
            $this->assertFalse($search->valid());
            $search->next();
            $this->assertFalse($search->current());
            $this->assertFalse($search->key());
            $this->assertFalse($search->valid());

            /*
            * search and simple iterate through the testentries.
            * then, rewind and do it again several times
            */
            $search2 = $ldap->search(null, '(ou=Net_LDAP2*)');
            $this->assertInstanceOf('Net_LDAP2_Search', $search2);
            $this->assertEquals(2, $search2->count());
            for ($i = 0; $i <= 5; $i++) {
                $counter = 0;
                foreach ($search2 as $dn => $entry) {
                    $counter++;

                    // check on type
                    $this->assertInstanceOf('Net_LDAP2_Entry', $entry);

                    // check on key
                    $this->assertThat(strlen($dn), $this->greaterThan(1));
                    $this->assertEquals($dn, $entry->dn());
                }
                $this->assertEquals($search2->count(), $counter, "Failed at loop $i");

                // revert to start
                $search2->rewind();
            }

            /*
            * Cleanup
            */
            $this->assertTrue($ldap->delete($ou1), 'Cleanup failed, please delete manually');
            $this->assertTrue($ldap->delete($ou2), 'Cleanup failed, please delete manually');
        }
    }
}

// Call Net_LDAP2_SearchTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "Net_LDAP2_SearchTest::main") {
    Net_LDAP2_SearchTest::main();
}
?>
