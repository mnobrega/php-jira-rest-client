<?php
/**
 * Created by PhpStorm.
 * User: mnobrega
 * Date: 04/02/2018
 * Time: 23:49
 */

use JiraRestApi\Version\VersionService;
use JiraRestApi\Version\Version;
use JiraRestApi\Project\ProjectService;

class VersionTest extends PHPUnit_Framework_TestCase
{
    private $projectId;
    private $versionService;

    /**
     * VersionTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     * @throws JsonMapper_Exception
     * @throws \JiraRestApi\JiraException
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $projectService = new \JiraRestApi\Project\ProjectService();
        $project = $projectService->get("TEST");
        $this->projectId = $project->id;
        $this->versionService = new VersionService();
    }

    /**
     * @return string
     */
    public function testCreate()
    {
        try {
            $version = new Version();
            $version->setName("1.0.0")
                ->setDescription("Dummy Description")
                ->setStartDate(new \DateTime())
                ->setReleaseDate(new \DateTime("2020-01-01"))
                ->setProjectId($this->projectId);
            $version = $this->versionService->create($version);
            $this->assertObjectHasAttribute("id",$version,"testCreate has failed, no ID");
            $versionId = $version->id;
            return $versionId;
        } catch (Exception $e) {
            $this->assertTrue(false,"versionCreate failed: ".$e->getMessage());
        }
    }

    public function testMove()
    {
        $this->markTestSkipped();
    }

    /**
     * @param $versionId
     * @depends testCreate
     */
    public function testGet($versionId)
    {
        try {
            $version = $this->versionService->get($versionId);
            $this->assertObjectHasAttribute('id',$version,"testGet has failed.");
        } catch (\Exception $e) {
            $this->assertTrue(false,"testGet failed:".$e->getMessage());
        }
    }

    /**
     * @param $version
     * @depends testGet
     */
    public function testUpdate($version)
    {
        try {

        } catch (\Exception $e) {
            $this->assertTrue(false,"testUpdateFailed: ".$e->getMessage());
        }
    }

    /**
     * @param $versionId
     * @depends testCreate
     */
    public function testDelete($versionId)
    {
        try {
            $result = $this->versionService->delete($versionId);
            $this->assertTrue($result,"testDelete failed. Result is not true.");
        } catch (\Exception $e) {
            $this->assertTrue(false,"versionDelete failed:".$e->getMessage());
        }
    }

    public function testGetRelatedIssues()
    {
        $this->markTestSkipped();
    }
}
