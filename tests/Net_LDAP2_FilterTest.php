<?php
// Call Net_LDAP2_FilterTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "Net_LDAP2_FilterTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'Net/LDAP2/Filter.php';

/**
 * Test class for Net_LDAP2_Filter.
 * Generated by PHPUnit_Util_Skeleton on 2007-10-09 at 10:34:23.
 */
class Net_LDAP2_FilterTest extends PHPUnit_Framework_TestCase {
    /**
    * @var string   default filter string to test with
    */
    var $filter_str = '(&(cn=foo)(ou=bar))';

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("Net_LDAP2_FilterTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
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
     * This tests the perl compatible creation of filters through parsing of an filter string
     */
    public function testCreatePerlCompatible() {
        $filter_o = new Net_LDAP2_Filter($this->filter_str);
        $this->assertType('Net_LDAP2_Filter', $filter_o);
        $this->assertEquals($this->filter_str, $filter_o->asString());

        $filter_o_err = new Net_LDAP2_Filter('some bad filter');
        $this->assertType('PEAR_Error', $filter_o_err->asString());
    }

    /**
     * Test correct parsing of filter strings through parse()
     */
    public function testParse() {
       $parsed_dmg = Net_LDAP2_Filter::parse('some_damaged_filter_str');
       $this->assertType('PEAR_Error', $parsed_dmg);

       $parsed_dmg2 = Net_LDAP2_Filter::parse('(invalid=filter)(because=~no-surrounding brackets)');
       $this->assertType('PEAR_Error', $parsed_dmg2);

       $parsed_dmg3 = Net_LDAP2_Filter::parse('((invalid=filter)(because=log_op is missing))');
       $this->assertType('PEAR_Error', $parsed_dmg3);

       $parsed_dmg4 = Net_LDAP2_Filter::parse('(invalid-because-becauseinvalidoperator)');
       $this->assertType('PEAR_Error', $parsed_dmg4);

       $parsed_dmg5 = Net_LDAP2_Filter::parse('(&(filterpart>=ok)(part2=~ok)(filterpart3_notok---becauseinvalidoperator))');
       $this->assertType('PEAR_Error', $parsed_dmg5);

       $parsed = Net_LDAP2_Filter::parse($this->filter_str);
       $this->assertType('Net_LDAP2_Filter', $parsed);
       $this->assertEquals($this->filter_str, $parsed->asString());
    }


    /**
     * This tests the basic create() method of creating filters
     */
    public function testCreate() {
        // Test values and an array containing the filter
        // creating methods and an regex to test the resulting filter
        $testattr = 'testattr';
        $testval  = 'testval';
        $combinations = array(
            'equals'         => "/\($testattr=$testval\)/",
            'begins'         => "/\($testattr=$testval\*\)/",
            'ends'           => "/\($testattr=\*$testval\)/",
            'contains'       => "/\($testattr=\*$testval\*\)/",
            'greater'        => "/\($testattr>$testval\)/",
            'less'           => "/\($testattr<$testval\)/",
            'greaterorequal' => "/\($testattr>=$testval\)/",
            'lessorequal'    => "/\($testattr<=$testval\)/",
            'approx'         => "/\($testattr~=$testval\)/",
            'any'            => "/\($testattr=\*\)/"
        );

        foreach ($combinations as $match => $regex) {
            // escaping is tested in util class
            $filter = Net_LDAP2_Filter::create($testattr, $match, $testval, false);

            $this->assertType('Net_LDAP2_Filter', $filter);
            $this->assertRegExp($regex, $filter->asString(), "Filter generation failed for MatchType: $match");
        }

        // test creating failure
        $filter = Net_LDAP2_Filter::create($testattr, 'test_undefined_matchingrule', $testval);
        $this->assertType('PEAR_Error', $filter);
    }

    /**
     * Tests, if asString() works
     */
    public function testAsString() {
        $filter = Net_LDAP2_Filter::create('foo', 'equals', 'bar');
        $this->assertType('Net_LDAP2_Filter', $filter);
        $this->assertEquals('(foo=bar)', $filter->asString());
        $this->assertEquals('(foo=bar)', $filter->as_string());
    }

    /**
     * Tests, if printMe() works
     */
    public function testPrintMe() {
        if (substr(strtolower(PHP_OS), 0,3) == 'win') {
            $testfile = '/tmp/Net_LDAP2_Filter_printMe-Testfile';
        } else {
            $testfile = 'c:\Net_LDAP2_Filter_printMe-Testfile';
        }
        $filter = Net_LDAP2_Filter::create('testPrintMe', 'equals', 'ok');
        $this->assertType('Net_LDAP2_Filter', $filter);

        // print success:
        ob_start();
        $printresult = $filter->printMe();
        ob_end_clean();
        $this->assertTrue($printresult);

        // PrintMe if Filehandle is an error (e.g. if some PEAR-File db is used):
        $err = new PEAR_Error();
        $this->assertType('PEAR_Error', $filter->printMe($err));

        // PrintMe if filter is damaged,
        // $filter_dmg is used below too, to test printing to a file with
        // damaged filter
        $filter_dmg = new Net_LDAP2_Filter('damaged_filter_string');

        // write success:
        $file = @fopen($testfile, 'w');
        if (is_writable($testfile) && $file) {
            $this->assertTrue($filter->printMe($file));
            $this->assertType('PEAR_Error', $filter_dmg->printMe($file)); // dmg. filter
            @fclose($file);
        } else {
            $this->markTestSkipped("$testfile could not be opened in write mode, skipping write test");
        }
        // write failure:
        $file = @fopen($testfile, 'r');
        if (is_writable($testfile) && $file) {
            $this->assertType('PEAR_Error', $filter->printMe($file));
            @fclose($file);
            @unlink($testfile);
        } else {
            $this->markTestSkipped("$testfile could not be opened in read mode, skipping write test");
        }
    }

    /**
     * This tests the basic cobination of filters
     */
    public function testCombine() {
        // Setup
        $filter0 = Net_LDAP2_Filter::create('foo', 'equals', 'bar');
        $this->assertType('Net_LDAP2_Filter', $filter0);

        $filter1 = Net_LDAP2_Filter::create('bar', 'equals', 'foo');
        $this->assertType('Net_LDAP2_Filter', $filter1);

        $filter2 = Net_LDAP2_Filter::create('you', 'equals', 'me');
        $this->assertType('Net_LDAP2_Filter', $filter2);

        $filter3 = new Net_LDAP2_Filter('(perlinterface=used)');
        $this->assertType('Net_LDAP2_Filter', $filter3);

        // Negation test
        $filter_not1 = Net_LDAP2_Filter::combine('not', $filter0);
        $this->assertType('Net_LDAP2_Filter', $filter_not1, 'Negation failed for literal NOT');
        $this->assertEquals('(!(foo=bar))', $filter_not1->asString());

        $filter_not2 = Net_LDAP2_Filter::combine('!', $filter0);
        $this->assertType('Net_LDAP2_Filter', $filter_not2, 'Negation failed for logical NOT');
        $this->assertEquals('(!(foo=bar))', $filter_not2->asString());

        $filter_not3 = Net_LDAP2_Filter::combine('!', $filter0->asString());
        $this->assertType('Net_LDAP2_Filter', $filter_not3, 'Negation failed for logical NOT');
        $this->assertEquals('(!'.$filter0->asString().')', $filter_not3->asString());


        // Combination test: OR
        $filter_comb_or1 = Net_LDAP2_Filter::combine('or', array($filter1, $filter2));
        $this->assertType('Net_LDAP2_Filter', $filter_comb_or1, 'Combination failed for literal OR');
        $this->assertEquals('(|(bar=foo)(you=me))', $filter_comb_or1->asString());

        $filter_comb_or2 = Net_LDAP2_Filter::combine('|', array($filter1, $filter2));
        $this->assertType('Net_LDAP2_Filter', $filter_comb_or2, 'combination failed for logical OR');
        $this->assertEquals('(|(bar=foo)(you=me))', $filter_comb_or2->asString());


        // Combination test: AND
        $filter_comb_and1 = Net_LDAP2_Filter::combine('and', array($filter1, $filter2));
        $this->assertType('Net_LDAP2_Filter', $filter_comb_and1, 'Combination failed for literal AND');
        $this->assertEquals('(&(bar=foo)(you=me))', $filter_comb_and1->asString());

        $filter_comb_and2 = Net_LDAP2_Filter::combine('&', array($filter1, $filter2));
        $this->assertType('Net_LDAP2_Filter', $filter_comb_and2, 'combination failed for logical AND');
        $this->assertEquals('(&(bar=foo)(you=me))', $filter_comb_and2->asString());


        // Combination test: using filter created with perl interface
        $filter_comb_perl1 = Net_LDAP2_Filter::combine('and', array($filter1, $filter3));
        $this->assertType('Net_LDAP2_Filter', $filter_comb_perl1, 'Combination failed for literal AND');
        $this->assertEquals('(&(bar=foo)(perlinterface=used))', $filter_comb_perl1->asString());

        $filter_comb_perl2 = Net_LDAP2_Filter::combine('&', array($filter1, $filter3));
        $this->assertType('Net_LDAP2_Filter', $filter_comb_perl2, 'combination failed for logical AND');
        $this->assertEquals('(&(bar=foo)(perlinterface=used))', $filter_comb_perl2->asString());


        // Combination test: using filter_str instead of object
        $filter_comb_fstr1 = Net_LDAP2_Filter::combine('and', array($filter1, '(filter_str=foo)'));
        $this->assertType('Net_LDAP2_Filter', $filter_comb_fstr1, 'Combination failed for literal AND using filter_str');
        $this->assertEquals('(&(bar=foo)(filter_str=foo))', $filter_comb_fstr1->asString());


        // Combination test: deep combination
        $filter_comp_deep = Net_LDAP2_Filter::combine('and',array($filter2, $filter_not1, $filter_comb_or1, $filter_comb_perl1));
        $this->assertType('Net_LDAP2_Filter', $filter_comp_deep, 'Deep combination failed!');
        $this->assertEquals('(&(you=me)(!(foo=bar))(|(bar=foo)(you=me))(&(bar=foo)(perlinterface=used)))', $filter_comp_deep->AsString());


        // Test failure in combination
        $damaged_filter  = Net_LDAP2_Filter::create('foo', 'test_undefined_matchingrule', 'bar');
        $this->assertType('PEAR_Error', $damaged_filter);
        $filter_not_dmg0 = Net_LDAP2_Filter::combine('not', $damaged_filter);
        $this->assertType('PEAR_Error', $filter_not_dmg0);

        $filter_not_dmg0s = Net_LDAP2_Filter::combine('not', 'damaged_filter_str');
        $this->assertType('PEAR_Error', $filter_not_dmg0s);

        $filter_not_multi = Net_LDAP2_Filter::combine('not', array($filter0, $filter1));
        $this->assertType('PEAR_Error', $filter_not_multi);

        $filter_not_dmg1 = Net_LDAP2_Filter::combine('not', null);
        $this->assertType('PEAR_Error', $filter_not_dmg1);

        $filter_not_dmg2 = Net_LDAP2_Filter::combine('and', $filter_not1);
        $this->assertType('PEAR_Error', $filter_not_dmg2);

        $filter_not_dmg3 = Net_LDAP2_Filter::combine('and', array($filter_not1));
        $this->assertType('PEAR_Error', $filter_not_dmg3);

        $filter_not_dmg4 = Net_LDAP2_Filter::combine('and', $filter_not1);
        $this->assertType('PEAR_Error', $filter_not_dmg4);

        $filter_not_dmg5 = Net_LDAP2_Filter::combine('or', array($filter_not1));
        $this->assertType('PEAR_Error', $filter_not_dmg5);

        $filter_not_dmg5 = Net_LDAP2_Filter::combine('some_unknown_method', array($filter_not1));
        $this->assertType('PEAR_Error', $filter_not_dmg5);

        $filter_not_dmg6 = Net_LDAP2_Filter::combine('and', array($filter_not1, 'some_invalid_filterstring'));
        $this->assertType('PEAR_Error', $filter_not_dmg6);

        $filter_not_dmg7 = Net_LDAP2_Filter::combine('and', array($filter_not1, $damaged_filter));
        $this->assertType('PEAR_Error', $filter_not_dmg7);

        $filter_not_dmg8 = Net_LDAP2_Filter::combine('and', array($filter_not1, null));
        $this->assertType('PEAR_Error', $filter_not_dmg8);
    }
}

// Call Net_LDAP2_FilterTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "Net_LDAP2_FilterTest::main") {
    Net_LDAP2_FilterTest::main();
}
?>