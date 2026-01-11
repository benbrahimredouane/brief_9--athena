<?php
require_once 'config/database.php';
require_once 'core/App.php';
require_once 'utils/helpers.php';

require_once 'entities/User.php';
require_once 'entities/Project.php';
require_once 'entities/Sprint.php';
require_once 'entities/Task.php';
require_once 'entities/Comment.php';

require_once 'repositories/UserRepository.php';
require_once 'repositories/TaskRepository.php';
require_once 'repositories/ProjectRepository.php';
require_once 'repositories/SprintRepository.php';
require_once 'repositories/CommentRepository.php';

require_once 'services/AuthService.php';
require_once 'services/TaskServices.php';
require_once 'services/NotificationService.php';
require_once 'services/AdminService.php';
require_once 'services/ProjectService.php';
require_once 'services/CommentService.php';


$app = new App();
$db = $app->getConnection();

$userRepository = new UserRepository($db);
$taskRepository = new TaskRepository($db);
$projectRepository = new ProjectRepository($db);
$sprintRepository = new SprintRepository($db);
$commentRepository = new CommentRepository($db);


$authService = new AuthService($userRepository);
$taskService = new TaskService($taskRepository, $notificationService);
$adminService = new AdminService($userRepository, $db);
$projectService = new ProjectService($projectRepository);
$commentService = new CommentService($commentRepository, $notificationService);
$action = $_GET['action'] ?? 'home';

try {
    switch ($action) {
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = sanitize($_POST['email']);
                $password = $_POST['password'];

                $user = $authService->login($email, $password);
                App::redirect('index.php?action=dashboard');
            } else {
                require 'views/login.php';
            }
            break;

        case 'register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = sanitize($_POST['username']);
                $email = sanitize($_POST['email']);
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirm_password'];

                if ($password !== $confirmPassword) {
                    throw new Exception("Passwords don't match");
                }

                if (!validateEmail($email)) {
                    throw new Exception("Invalid email format");
                }

                $authService->register($username, $email, $password);
                App::redirect('index.php?action=login');
            } else {
                require 'views/register.php';
            }
            break;

        case 'dashboard':
            if (!App::isAuthenticated()) {
                App::redirect('index.php?action=login');
            }

            $userId = $_SESSION['user_id'];
            $userRole = $_SESSION['user_role'];

            if ($userRole === 'admin') {
                $stats = $adminService->getStatistics();
                $logs = $adminService->getSystemLogs(10);
                require 'views/admin_dashboard.php';
            } else {
            
                $filters = [
                    'q' => '',
                    'status' => '',
                    'priority' => '',
                    'project_id' => 2,
                    'assignee_id' => ''
                ];
                $tasks = $taskRepository->searchTasks($filters, 1, 10);

                require 'views/user_dashboard.php';
            }
            break;

        case 'create_task':
            if (!App::isAuthenticated()) {
                App::redirect('index.php?action=login');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $sprintId = $_POST['sprint_id'];
                $title = sanitize($_POST['title']);
                $description = sanitize($_POST['description']);
                $priority = $_POST['priority'];
                $creatorId = $_SESSION['user_id'];


                $assigneeId = $_SESSION['user_id'];

                try {
                    $taskService->createTask($sprintId, $title, $description, $priority, $assigneeId, $creatorId);
                    App::redirect('index.php?action=dashboard');
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    require 'views/create_task.php';
                }
            } else {
                require 'views/create_task.php';
            }
            break;

        case 'update_task_status':
            if (!App::isAuthenticated()) {
                App::redirect('index.php?action=login');
            }

            $taskId = $_GET['id'];
            $status = $_GET['status'];

            $taskService->changeTaskStatus($taskId, $status, $_SESSION['user_id']);
            App::redirect('index.php?action=dashboard');
            break;

        case 'admin_toggle_user':
            if (!App::isAuthenticated() || !App::hasRole('admin')) {
                App::redirect('index.php?action=dashboard');
            }

            $userId = $_GET['user_id'];
            $adminService->toggleUserStatus($userId);
            App::redirect('index.php?action=admin_users');
            break;

        case 'search_tasks':
            if (!App::isAuthenticated()) {
                App::redirect('index.php?action=login');
            }

            $searchTerm = $_GET['q'] ?? '';
            $status = $_GET['status'] ?? '';
            $priority = $_GET['priority'] ?? '';
            $assigneeId = $_GET['assignee'] ?? '';
            $page = $_GET['page'] ?? 1;

            $tasks = $taskRepository->searchTasks($searchTerm, $status, $priority, $assigneeId, $page, 10);
            require 'views/search_results.php';
            break;

        case 'logout':
            $authService->logout();
            App::redirect('index.php?action=login');
            break;
        case 'admin_users':
            if (!App::isAuthenticated() || !App::hasRole('admin')) {
                App::redirect('index.php?action=dashboard');
            }

            $users = $userRepository->getAllUsers();
            require 'views/admin_users.php';
            break;


        case 'admin_projects':
            if (!App::isAuthenticated() || !App::hasRole('admin')) {
                App::redirect('index.php?action=dashboard');
            }

            $projects = $projectService->getAllProjects();
            require 'views/admin_projects.php';
            break;

        case 'create_project':
            if (!App::isAuthenticated() || !App::hasRole('admin')) {
                App::redirect('index.php?action=dashboard');
            }

            require 'views/create_project.php';
            break;

        case 'save_project':
            if (!App::isAuthenticated() || !App::hasRole('admin')) {
                App::redirect('index.php?action=dashboard');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = sanitize($_POST['name']);
                $description = sanitize($_POST['description']);
                $leaderId = sanitize($_POST['leader_id']);

                $projectService->createProject($name, $description, $leaderId);
                App::redirect('index.php?action=admin_projects');
            }
            break;

        case 'toggle_project':
            if (!App::isAuthenticated() || !App::hasRole('admin')) {
                App::redirect('index.php?action=dashboard');
            }

            $projectId = $_GET['id'];
            $projectService->toggleProjectStatus($projectId);
            App::redirect('index.php?action=admin_projects');
            break;
        case 'edit_project':
            if (!App::isAuthenticated() || !App::hasRole('admin')) {
                App::redirect('index.php?action=dashboard');
            }

            $projectId = $_GET['id'] ?? 0;


            $project = $projectService->getProjectDetails($projectId);

            if (!$project) {
                echo "Project not found!";
                exit;
            }


            $userRepository = new UserRepository($db);
            $allUsers = $userRepository->getAllUsers();

            require 'views/edit_project.php';
            break;
        case 'update_project':
            if (!App::isAuthenticated() || !App::hasRole('admin')) {
                App::redirect('index.php?action=dashboard');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $projectId = $_POST['id'];
                $name = sanitize($_POST['name']);
                $description = sanitize($_POST['description']);
                $leaderId = $_POST['leader_id'];
                $isActive = $_POST['is_active'] ?? 1;


                $query = "UPDATE projects 
                  SET name = :name, description = :description, 
                      leader_id = :leader_id, is_active = :is_active
                  WHERE id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':leader_id', $leaderId);
                $stmt->bindParam(':is_active', $isActive);
                $stmt->bindParam(':id', $projectId);
                $stmt->execute();


                $checkQuery = "SELECT COUNT(*) FROM project_members 
                       WHERE project_id = :project_id AND user_id = :user_id";
                $checkStmt = $db->prepare($checkQuery);
                $checkStmt->bindParam(':project_id', $projectId);
                $checkStmt->bindParam(':user_id', $leaderId);
                $checkStmt->execute();
                $count = $checkStmt->fetchColumn();

                if ($count == 0) {
                    $addQuery = "INSERT INTO project_members (project_id, user_id) 
                         VALUES (:project_id, :user_id)";
                    $addStmt = $db->prepare($addQuery);
                    $addStmt->bindParam(':project_id', $projectId);
                    $addStmt->bindParam(':user_id', $leaderId);
                    $addStmt->execute();
                }

                App::redirect('index.php?action=admin_projects');
            }
            break;
        case 'profile':
            if (!App::isAuthenticated()) {
                App::redirect('index.php?action=login');
            }

            $userRepository = new UserRepository($db);
            $user = $userRepository->findById($_SESSION['user_id']);
            require 'views/profile.php';
            break;

        case 'update_profile':
            if (!App::isAuthenticated()) {
                App::redirect('index.php?action=login');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userId = $_SESSION['user_id'];
                $username = sanitize($_POST['username']);
                $email = sanitize($_POST['email']);
                $currentPassword = $_POST['current_password'];
                $newPassword = $_POST['new_password'];

                $userRepository = new UserRepository($db);
                $currentUser = $userRepository->findById($userId);

               
                if (!empty($currentPassword) && !password_verify($currentPassword, $currentUser['password'])) {
                    $error = "Current password is incorrect";
                    $user = $currentUser;
                    require 'views/profile.php';
                    break;
                }

              
                $userRepository->updateProfile($userId, $username, $email);

               
                if (!empty($newPassword) && $newPassword === $_POST['confirm_password']) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $query = "UPDATE users SET password = :password WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':password', $hashedPassword);
                    $stmt->bindParam(':id', $userId);
                    $stmt->execute();
                }

                $_SESSION['username'] = $username;
                $success = "Profile updated successfully!";
                $user = $userRepository->findById($userId);
                require 'views/profile.php';
            }
            break;
        case 'create_sprint':
            if (!App::isAuthenticated() || !App::hasRole('project_leader')) {
                App::redirect('index.php?action=dashboard');
            }

            $projectId = $_GET['project_id'];
            $project = $projectService->getProjectDetails($projectId);


            if ($_SESSION['user_id'] != $project['leader_id']) {
                App::redirect('index.php?action=dashboard');
            }

            require 'views/create_sprint.php';
            break;

        case 'save_sprint':
            if (!App::isAuthenticated() || !App::hasRole('project_leader')) {
                App::redirect('index.php?action=dashboard');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $projectId = $_POST['project_id'];
                $name = sanitize($_POST['name']);
                $startDate = $_POST['start_date'];
                $endDate = $_POST['end_date'];
                $goal = sanitize($_POST['goal']);


                if ($endDate <= $startDate) {
                    $error = "End date must be after start date";
                    require 'views/create_sprint.php';
                    break;
                }

                $sprintRepository = new SprintRepository($db);
                $sprintRepository->createSprint($projectId, $name, $startDate, $endDate, $goal);

                App::redirect('index.php?action=project_sprints&project_id=' . $projectId);
            }
            break;

        case 'project_sprints':
            if (!App::isAuthenticated()) {
                App::redirect('index.php?action=login');
            }

            $projectId = $_GET['project_id'];
            $project = $projectService->getProjectDetails($projectId);


            $isMember = false;
            foreach ($project['members'] as $member) {
                if ($member['id'] == $_SESSION['user_id']) {
                    $isMember = true;
                    break;
                }
            }

            if (!$isMember && !App::hasRole('admin')) {
                App::redirect('index.php?action=dashboard');
            }

            $sprintRepository = new SprintRepository($db);
            $sprints = $sprintRepository->getSprintsByProject($projectId);

            require 'views/project_sprints.php';
            break;
        case 'view_task':
            if (!App::isAuthenticated()) {
                App::redirect('index.php?action=login');
            }

            $taskId = $_GET['id'];
            $task = $taskRepository->findById($taskId);

            if (!$task) {
                echo "Task not found";
                exit;
            }

           
            $query = "SELECT t.*, u.username as assignee_name 
              FROM tasks t
              LEFT JOIN users u ON t.assignee_id = u.id
              WHERE t.id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $taskId);
            $stmt->execute();
            $task = $stmt->fetch(PDO::FETCH_ASSOC);

            
            $comments = $commentService->getTaskComments($taskId);

            require 'views/task_detail.php';
            break;

        case 'add_comment':
            if (!App::isAuthenticated()) {
                App::redirect('index.php?action=login');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $taskId = $_POST['task_id'];
                $content = sanitize($_POST['content']);

                try {
                    $commentService->addComment($taskId, $_SESSION['user_id'], $content);
                    App::redirect('index.php?action=view_task&id=' . $taskId);
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    
                    $task = $taskRepository->findById($taskId);
                    $comments = $commentService->getTaskComments($taskId);
                    require 'views/task_detail.php';
                }
            }
            break;

        case 'delete_comment':
            if (!App::isAuthenticated()) {
                App::redirect('index.php?action=login');
            }

            $commentId = $_GET['id'];
            $taskId = $_GET['task_id'];

            try {
                $commentService->deleteComment($commentId, $_SESSION['user_id'], $_SESSION['user_role']);
                App::redirect('index.php?action=view_task&id=' . $taskId);
            } catch (Exception $e) {
                $error = $e->getMessage();
                $task = $taskRepository->findById($taskId);
                $comments = $commentService->getTaskComments($taskId);
                require 'views/task_detail.php';
            }
            break;
        default:
            if (App::isAuthenticated()) {
                App::redirect('index.php?action=dashboard');
            } else {
                App::redirect('index.php?action=login');
            }
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    require 'views/error.php';
}
