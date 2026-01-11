<?php
class Task {
    private $id;
    private $sprintId;
    private $title;
    private $description;
    private $status;
    private $priority;
    private $assigneeId;
    private $creatorId;

    public function __construct($id, $sprintId, $title, $description, $status, $priority, $assigneeId, $creatorId) {
        $this->id = $id;
        $this->sprintId = $sprintId;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->priority = $priority;
        $this->assigneeId = $assigneeId;
        $this->creatorId = $creatorId;
    }

    public function getId() { return $this->id; }
    public function getSprintId() { return $this->sprintId; }
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getStatus() { return $this->status; }
    public function getPriority() { return $this->priority; }
    public function getAssigneeId() { return $this->assigneeId; }
    public function getCreatorId() { return $this->creatorId; }

    public function setStatus($status) { $this->status = $status; }
    public function setAssignee($assigneeId) { $this->assigneeId = $assigneeId; }
}