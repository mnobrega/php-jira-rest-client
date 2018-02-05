<?php

namespace JiraRestApi\Version;

use JiraRestApi\JiraClient;
use JiraRestApi\JiraException;

class VersionService extends JiraClient
{
    private $uri = '/version';

    /**
     * create version.
     * @param $version
     * @return Version|object
     * @throws JiraException
     * @throws \JsonMapper_Exception
     * @see https://docs.atlassian.com/jira/REST/server/#api/2/version-createVersion
     */
    public function create($version)
    {
        $data = json_encode($version);
        $this->log->addInfo("Create Version=\n".$data);
        $ret = $this->exec($this->uri, $data, 'POST');
        return $this->getVersionFromJson($ret);
    }

    /**
     * @throws JiraException
     */
    public function move()
    {
        throw new JiraException('move version not yet implemented');
    }

    /**
     * @param integer $versionId
     * @return Version|object
     * @throws JiraException
     * @throws \JsonMapper_Exception
     */
    public function get($versionId)
    {
        $ret = $this->exec($this->uri.'/'.$versionId);
        $this->log->addInfo('Result='.$ret);
        return $this->getVersionFromJson($ret);
    }

    /**
     * @param $versionId
     * @param Version $version
     * @return Version|object
     * @throws JiraException
     * @throws \JsonMapper_Exception
     */
    public function update($versionId, Version $version)
    {
        $data = json_encode($version);
        $this->log->addInfo("Update Version=\n".$data);
        $ret = $this->exec($this->uri."/$versionId", $data, 'PUT');
        return $this->getVersionFromJson($ret);
    }

    /**
     * @param $versionId
     * @return string
     * @throws JiraException
     */
    public function delete($versionId)
    {
        $this->log->addInfo("deleteVersion=\n");
        $ret = $this->exec($this->uri."/".$versionId,'','DELETE');
        $this->log->addInfo('delete version '.$versionId." result=".var_export($ret,true));
        return $ret;
    }

    /**
     * @throws JiraException
     */
    public function merge()
    {
        throw new JiraException('merge version not yet implemented');
    }

    /**
     * @throws JiraException
     */
    public function getRelatedIssues()
    {
        throw new JiraException('get version Related Issues not yet implemented');
    }

    /**
     * @param $json
     * @return Version|object
     * @throws \JsonMapper_Exception
     */
    private function getVersionFromJson($json)
    {
        $version = $this->json_mapper->map(
            json_decode($json), new Version()
        );
        return $version;
    }
}
