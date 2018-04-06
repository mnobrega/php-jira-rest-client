<?php

namespace JiraRestApi\IssueLink;

class IssueLinkService extends \JiraRestApi\JiraClient
{
    private $uri = '';

    /**
     * @param IssueLink $issueLink
     *
     * @throws \JiraRestApi\JiraException
     */
    public function addIssueLink($issueLink)
    {
        $this->log->addInfo("addIssueLink=\n");

        $data = json_encode($issueLink);

        $this->log->addDebug("Create IssueLink=\n".$data);

        $url = $this->uri.'/issueLink';
        $type = 'POST';

        $this->exec($url, $data, $type);
    }

    /**
     * @throws \JiraRestApi\JiraException
     *
     * @return IssueLinkType[]
     */
    public function getIssueLinkTypes()
    {
        $this->log->addInfo("getIssueLinkTYpes=\n");

        $url = $this->uri.'/issueLinkType';

        $ret = $this->exec($url);

        $data = json_encode(json_decode($ret)->issueLinkTypes);

        $linkTypes = $this->json_mapper->mapArray(
            json_decode($data, false), new \ArrayObject(), '\JiraRestApi\IssueLink\IssueLinkType'
        );

        return $linkTypes;
    }

    /**
     * @param $issueLinkId
     * @return string
     * @throws \JiraRestApi\JiraException
     */
    public function deleteIssueLink($issueLinkId)
    {
        $this->log->addInfo("deleteIssueLink=\n");
        $ret = $this->exec($this->uri."/issueLink/$issueLinkId", '', 'DELETE');
        $this->log->addInfo('delete issueLink '.$issueLinkId.' result='.var_export($ret, true));
        return $ret;
    }
}
