<?php
class Sprint {
    private $id;
    private $projectId;
    private $name;
    private $startDate;
    private $endDate;
    private $goal;

    public function __construct($id, $projectId, $name, $startDate, $endDate, $goal) {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->goal = $goal;
    }

    public function getId() { return $this->id; }
    public function getProjectId() { return $this->projectId; }
    public function getName() { return $this->name; }
    public function getStartDate() { return $this->startDate; }
    public function getEndDate() { return $this->endDate; }
    public function getGoal() { return $this->goal; }
}