<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectListDirectoriesTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray\Tests;

/**
 * This class contains tests for directory related methods in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Ray\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectListDirectoriesTest extends PhysicalFilesystemAccessObjectTestCase
{

    /**
     * Test listing directories in an accessible directory.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInAccessibleDirectory(): void
    {
        $expected = [ 'folder1', 'folder2' ];

        $value = $this->class->get_list_of_directories($this->find_location);

        $this->assertIsArray($value);

        sort($value);

        $this->assertEquals($expected, $value);
    }

    /**
     * Test listing directories in an inaccessible directory.
     *
     * @requires OS Linux
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInInaccessibleDirectory(): void
    {
        $directory = '/root';

        if (PHP_VERSION_ID >= 80000)
        {
            $error = "DirectoryIterator::__construct($directory): Failed to open directory: Permission denied";
        }
        else
        {
            $error = "DirectoryIterator::__construct($directory): failed to open dir: Permission denied";
        }

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => $error,
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->get_list_of_directories($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing directories in an non-existent directory.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInNonExistentDirectory(): void
    {
        $directory = '/tmp56474q';

        if (PHP_VERSION_ID >= 80000)
        {
            $error = "DirectoryIterator::__construct($directory): Failed to open directory: No such file or directory";
        }
        else
        {
            $error = "DirectoryIterator::__construct($directory): failed to open dir: No such file or directory";
        }

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => $error,
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->get_list_of_directories($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing directories in a file.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInFile(): void
    {
        $directory = tempnam('/tmp', 'phpunit_');;

        if (PHP_VERSION_ID >= 80000)
        {
            $error = "DirectoryIterator::__construct($directory): Failed to open directory: Not a directory";
        }
        else
        {
            $error = "DirectoryIterator::__construct($directory): failed to open dir: Not a directory";
        }

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => $error,
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->get_list_of_directories($directory);

        $this->assertArrayEmpty($value);

        unlink($directory);
    }

    /**
     * Test listing directories in an boolean directory.
     *
     * @param bool $directory Boolean directory value
     *
     * @requires     PHP < 8
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Ray\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInBooleanDirectory($directory): void
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->get_list_of_directories($directory);

        $this->assertArrayEmpty($value);
    }

}

?>
