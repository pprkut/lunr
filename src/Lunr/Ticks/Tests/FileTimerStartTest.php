<?php

/**
 * This file contains the FileTimerStartTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Ticks\Tests;

/**
 * This class contains test for starting and adding tags to timers.
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Ticks\FileTimer
 */
class FileTimerStartTest extends FileTimerTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpNoRequest();
    }

    /**
     * Test that starting a new Timer without giving ID returns autogenerated ID.
     *
     * @covers Lunr\Ticks\FileTimer::start
     */
    public function testStartWithoutIDReturnsAutoIncrementedCounter()
    {
        $this->assertEquals(0, $this->class->start());
    }

    /**
     * Test that starting a new Timer with given ID returns ID.
     *
     * @covers Lunr\Ticks\FileTimer::start
     */
    public function testStartWithIDReturnsID()
    {
        $this->assertEquals('id', $this->class->start('id'));
    }

    /**
     * Test that starting a Timer with an existing ID returns FALSE.
     *
     * @covers Lunr\Ticks\FileTimer::start
     */
    public function testStartWithExistingIDReturnsFalse()
    {
        $timers = [ 'id' => [] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->assertFalse($this->class->start('id'));
    }

    /**
     * Test that starting a new Timer adds the timer to the timers array.
     *
     * @covers Lunr\Ticks\FileTimer::start
     */
    public function testStartAddsBootstrappedTimerToTimers()
    {
        $id    = $this->class->start();
        $timer = $this->get_reflection_property_value('timers')[$id];

        $this->assertArrayHasKey('start', $timer);
        $this->assertArrayHasKey('stop', $timer);
        $this->assertArrayHasKey('stopped', $timer);
        $this->assertArrayHasKey('tags', $timer);

        $this->assertInternalType('float', $timer['start']);
        $this->assertEquals(0, $timer['stop']);
        $this->assertFALSE($timer['stopped']);
        $this->assertArrayEmpty($timer['tags']);
    }

    /**
     * Test that starting a new Timer with a non-existing ID increments the counter.
     *
     * @covers Lunr\Ticks\FileTimer::start
     */
    public function testStartWithNonExistingIDIncrementsCounter()
    {
        $counter = $this->get_accessible_reflection_property('counter');

        $this->assertEquals(0, $counter->getValue($this->class));
        $this->class->start();
        $this->assertEquals(1, $counter->getValue($this->class));
    }

    /**
     * Test that starting a new Timer with an existing ID does not increment the counter.
     *
     * @covers Lunr\Ticks\FileTimer::start
     */
    public function testStartWithExistingIDDoesIncrementCounter()
    {
        $timers = [ 0 => [] ];
        $this->set_reflection_property_value('timers', $timers);

        $counter = $this->get_accessible_reflection_property('counter');

        $this->assertEquals(0, $counter->getValue($this->class));
        $this->class->start();
        $this->assertEquals(1, $counter->getValue($this->class));
    }

    /**
     * Test that starting a new Timer with a given ID does not increment the counter.
     *
     * @covers Lunr\Ticks\FileTimer::start
     */
    public function testStartWithGivenIDDoesNotIncrementCounter()
    {
        $counter = $this->get_accessible_reflection_property('counter');

        $this->assertEquals(0, $counter->getValue($this->class));
        $this->class->start('id');
        $this->assertEquals(0, $counter->getValue($this->class));
    }

    /**
     * Test that adding tags to a non-existing timer returns FALSE.
     *
     * @covers Lunr\Ticks\FileTimer::add_tags
     */
    public function testAddTagsReturnsFalseForNonExistantID()
    {
        $this->assertFalse($this->class->add_tags(0, ['tag1']));
    }

    /**
     * Test that adding no tags to a timer returns FALSE.
     *
     * @covers Lunr\Ticks\FileTimer::add_tags
     */
    public function testAddTagsReturnsFalseForForEmptyTags()
    {
        $timers = [ 0 => [ 'tags' => [] ] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->assertFalse($this->class->add_tags(0, []));
    }

    /**
     * Test that adding invalid tags to a timer returns FALSE.
     *
     * @covers Lunr\Ticks\FileTimer::add_tags
     */
    public function testAddTagsReturnsFalseForInvalidTags()
    {
        $timers = [ 0 => [ 'tags' => [] ] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->assertFalse($this->class->add_tags(0, 'string'));
    }

    /**
     * Test adding tags to a timer.
     *
     * @param array $existing Existing Tags
     * @param array $new      New Tags
     * @param array $expected Expected Tags
     *
     * @dataProvider tagsProvider
     * @covers       Lunr\Ticks\FileTimer::add_tags
     */
    public function testAddTagsSetsTags($existing, $new, $expected)
    {
        $timers = [ 0 => [ 'tags' => $existing ] ];
        $this->set_reflection_property_value('timers', $timers);

        $this->class->add_tags(0, $new);

        $this->assertEquals($expected, $this->get_reflection_property_value('timers')[0]['tags']);
    }

}

?>
