<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mavenlink Task & Time Tracker</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #2980b9;
        }
        .hidden {
            display: none;
        }
        .tabs {
            display: flex;
            margin-bottom: 20px;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #f1f1f1;
            border-radius: 5px 5px 0 0;
            margin-right: 2px;
        }
        .tab.active {
            background-color: #3498db;
            color: white;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .success-message {
            color: #27ae60;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }
        .error-message {
            color: #e74c3c;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }
        .info-message {
            color: #3498db;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }
        #debug-section {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        #debug-log {
            max-height: 200px;
            overflow-y: auto;
            background-color: #2c3e50;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            white-space: pre-wrap;
        }
        textarea.curl-command {
            font-family: monospace;
            background-color: #f5f5f5;
            padding: 15px;
            overflow: auto;
            white-space: pre;
            font-size: 14px;
            height: 120px;
        }
    </style>
</head>
<body>
    <h1>Mavenlink Task & Time Tracker</h1>
    
    <!-- API Authentication -->
    <div class="card" id="auth-section">
        <h2>API Authentication</h2>
        <div>
            <label for="api-token">Mavenlink API Token:</label>
            <input type="password" id="api-token" placeholder="Enter your Mavenlink API token">
            <button id="authenticate-btn">Authenticate</button>
            <button id="forget-token-btn" style="background-color: #e74c3c; margin-top: 10px;">Forget Saved Token</button>
            <div id="auth-message"></div>
        </div>
    </div>

    <!-- Main Content (hidden until authenticated) -->
    <div id="main-content" class="hidden">
        <div class="tabs">
            <div class="tab active" data-tab="create-task">Create Task</div>
            <div class="tab" data-tab="post-time">Post Time</div>
        </div>

        <!-- Create Task Section -->
        <div class="tab-content card active" id="create-task">
            <h2>Create New Task</h2>
            <div>
                <label for="project-select-task">Select Project:</label>
                <select id="project-select-task">
                    <option value="" disabled selected>No projects loaded</option>
                </select>
                
                <label for="task-name">Task Name:</label>
                <input type="text" id="task-name" placeholder="Enter task name">
                
                <label for="task-description">Description:</label>
                <textarea id="task-description" rows="4" placeholder="Enter task description"></textarea>
                
                <label for="start-date">Start Date:</label>
                <input type="date" id="start-date">
                
                <label for="due-date">Due Date:</label>
                <input type="date" id="due-date">
                
                <label for="assignee">Assignee:</label>
                <select id="assignee">
                    <option value="" disabled selected>No users loaded</option>
                </select>
                
                <div>
                    <h3>Create Task Command</h3>
                    <p>Copy and run this command in your terminal:</p>
                    <textarea class="curl-command" id="task-command" readonly></textarea>
                    <button id="copy-task-cmd" style="background-color: #34495e;">Copy Command</button>
                    <button id="generate-task-cmd" style="background-color: #2ecc71; margin-top: 10px;">Generate Command</button>
                </div>
                
                <div id="task-message"></div>
            </div>
        </div>

        <!-- Post Time Section -->
        <div class="tab-content card" id="post-time">
            <h2>Post Time Entry</h2>
            <div>
                <label for="project-select-time">Select Project:</label>
                <select id="project-select-time">
                    <option value="" disabled selected>No projects loaded</option>
                </select>
                
                <label for="task-select">Select Task (optional):</label>
                <select id="task-select">
                    <option value="" selected>No task (post to project)</option>
                </select>
                
                <label for="date">Date:</label>
                <input type="date" id="date" value="">
                
                <label for="time-hours">Hours:</label>
                <input type="number" id="time-hours" min="0" max="24" step="0.25" placeholder="Enter hours">
                
                <label for="time-notes">Notes:</label>
                <textarea id="time-notes" rows="4" placeholder="Enter notes for this time entry"></textarea>
                
                <div>
                    <h3>Post Time Command</h3>
                    <p>Copy and run this command in your terminal:</p>
                    <textarea class="curl-command" id="time-command" readonly></textarea>
                    <button id="copy-time-cmd" style="background-color: #34495e;">Copy Command</button>
                    <button id="generate-time-cmd" style="background-color: #2ecc71; margin-top: 10px;">Generate Command</button>
                </div>
                
                <div id="time-message"></div>
            </div>
        </div>
        
        <!-- Projects & Tasks Data Section -->
        <div class="card">
            <h2>Import Data</h2>
            <p>To get your projects and tasks, run this command in your terminal and paste the result below:</p>
            <textarea class="curl-command" id="data-command" readonly></textarea>
            <button id="copy-data-cmd" style="background-color: #34495e;">Copy Command</button>
            <button id="generate-data-cmd" style="background-color: #2ecc71; margin-top: 10px;">Generate Data Command</button>
            
            <h3>Paste Response Data</h3>
            <textarea id="response-data" rows="6" placeholder="Paste the JSON response from the command here"></textarea>
            <button id="process-data-btn">Process Data</button>
            <div id="data-message"></div>
        </div>
    </div>
    
    <!-- Debug Section -->
    <div class="card" id="debug-section">
        <h2>Debug Information</h2>
        <button id="toggle-debug-btn">Toggle Debug Console</button>
        <div id="debug-log" class="hidden"></div>
    </div>

    <script>
        // Set today's date as default for date inputs
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date').value = today;
        
        // Try to load token from localStorage
        let apiToken = localStorage.getItem('mavenlinkApiToken') || '';
        let projects = [];
        let users = [];
        let tasks = {};
        
        // Auto-authenticate if token exists
        window.addEventListener('DOMContentLoaded', () => {
            if (apiToken) {
                document.getElementById('api-token').value = apiToken;
                document.getElementById('authenticate-btn').click();
            }
            
            // Generate initial data command
            generateDataCommand();
        });
        
        // Debug console functionality
        const debugLog = document.getElementById('debug-log');
        const originalConsoleLog = console.log;
        const originalConsoleError = console.error;
        
        // Override console methods to capture output
        console.log = function() {
            // Call the original console.log
            originalConsoleLog.apply(console, arguments);
            
            // Add to our debug log
            const message = Array.from(arguments).map(arg => 
                typeof arg === 'object' ? JSON.stringify(arg, null, 2) : arg
            ).join(' ');
            
            debugLog.innerHTML += `<div class="log-entry">[LOG] ${message}</div>`;
            debugLog.scrollTop = debugLog.scrollHeight;
        };
        
        console.error = function() {
            // Call the original console.error
            originalConsoleError.apply(console, arguments);
            
            // Add to our debug log
            const message = Array.from(arguments).map(arg => 
                typeof arg === 'object' ? JSON.stringify(arg, null, 2) : arg
            ).join(' ');
            
            debugLog.innerHTML += `<div class="log-entry error">[ERROR] ${message}</div>`;
            debugLog.scrollTop = debugLog.scrollHeight;
        };
        
        // Toggle debug console
        document.getElementById('toggle-debug-btn').addEventListener('click', () => {
            debugLog.classList.toggle('hidden');
        });
        
        // Tab switching functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // Show corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
        
        // Authentication
        document.getElementById('authenticate-btn').addEventListener('click', () => {
            apiToken = document.getElementById('api-token').value.trim();
            
            if (!apiToken) {
                showMessage('auth-message', 'Please enter your API token', 'error');
                return;
            }
            
            // Save token to localStorage
            localStorage.setItem('mavenlinkApiToken', apiToken);
            
            showMessage('auth-message', 'Token saved. Please use the commands below to fetch data.', 'success');
            document.getElementById('main-content').classList.remove('hidden');
            
            // Generate commands with the new token
            generateDataCommand();
        });
        
        // Forget token
        document.getElementById('forget-token-btn').addEventListener('click', () => {
            localStorage.removeItem('mavenlinkApiToken');
            apiToken = '';
            document.getElementById('api-token').value = '';
            document.getElementById('main-content').classList.add('hidden');
            showMessage('auth-message', 'Saved token removed successfully', 'success');
        });
        
        // Generate Data Command
        function generateDataCommand() {
            const dataCommand = document.getElementById('data-command');
            const token = apiToken || 'YOUR_API_TOKEN';
            
            dataCommand.value = `curl -H "Authorization: Bearer ${token}" \\
  -H "Content-Type: application/json" \\
  -X GET "https://api.mavenlink.com/api/v1/workspaces"`;
            
            showMessage('data-message', 'Data command generated. Run this command and paste the result below.', 'info');
        }
        
        document.getElementById('generate-data-cmd').addEventListener('click', generateDataCommand);
        
        // Copy Data Command
        document.getElementById('copy-data-cmd').addEventListener('click', () => {
            const dataCommand = document.getElementById('data-command');
            dataCommand.select();
            document.execCommand('copy');
            showMessage('data-message', 'Command copied to clipboard', 'success');
        });
        
        // Process Data
        document.getElementById('process-data-btn').addEventListener('click', () => {
            const responseData = document.getElementById('response-data').value.trim();
            
            if (!responseData) {
                showMessage('data-message', 'Please paste the response data', 'error');
                return;
            }
            
            try {
                // Parse the JSON response
                const data = JSON.parse(responseData);
                
                if (data.workspaces) {
                    projects = Object.values(data.workspaces);
                    
                    // Sort projects by title
                    projects.sort((a, b) => a.title.localeCompare(b.title));
                    
                    // Populate project dropdowns
                    populateProjectDropdowns(projects);
                    
                    showMessage('data-message', `Loaded ${projects.length} projects successfully!`, 'success');
                    
                    // Now generate the curl command to get users
                    const dataCommand = document.getElementById('data-command');
                    dataCommand.value = `curl -H "Authorization: Bearer ${apiToken}" \\
  -H "Content-Type: application/json" \\
  -X GET "https://api.mavenlink.com/api/v1/users"`;
                    
                    showMessage('data-message', 'Now run the command to fetch users and paste the result.', 'info');
                } else if (data.users) {
                    users = Object.values(data.users);
                    
                    // Sort users by full name
                    users.sort((a, b) => a.full_name.localeCompare(b.full_name));
                    
                    // Populate assignee dropdown
                    populateUserDropdown(users);
                    
                    showMessage('data-message', `Loaded ${users.length} users successfully!`, 'success');
                } else if (data.stories) {
                    const loadedTasks = Object.values(data.stories);
                    const projectId = document.getElementById('project-select-time').value;
                    
                    // Store in tasks object by project ID
                    tasks[projectId] = loadedTasks;
                    
                    // Populate task dropdown
                    populateTaskDropdown(loadedTasks, projectId);
                    
                    showMessage('data-message', `Loaded ${loadedTasks.length} tasks for the selected project!`, 'success');
                } else {
                    showMessage('data-message', 'Unrecognized data format. Please check the response.', 'error');
                }
            } catch (error) {
                console.error('Error processing data:', error);
                showMessage('data-message', 'Error processing data: ' + error.message, 'error');
            }
        });
        
        // Populate project dropdowns
        function populateProjectDropdowns(projects) {
            const projectSelects = [
                document.getElementById('project-select-task'),
                document.getElementById('project-select-time')
            ];
            
            projectSelects.forEach(select => {
                // Clear existing options
                select.innerHTML = '';
                
                // Add default option
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select a project';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                select.appendChild(defaultOption);
                
                // Add projects
                projects.forEach(project => {
                    const option = document.createElement('option');
                    option.value = project.id;
                    option.textContent = project.title;
                    select.appendChild(option);
                });
            });
            
            // Add event listener for task loading
            document.getElementById('project-select-time').addEventListener('change', function() {
                const projectId = this.value;
                
                if (!projectId) return;
                
                // Generate command to get tasks for this project
                const dataCommand = document.getElementById('data-command');
                dataCommand.value = `curl -H "Authorization: Bearer ${apiToken}" \\
  -H "Content-Type: application/json" \\
  -X GET "https://api.mavenlink.com/api/v1/workspaces/${projectId}/stories"`;
                
                showMessage('data-message', 'Run this command to get tasks for the selected project.', 'info');
                
                // Check if we already have tasks for this project
                if (tasks[projectId]) {
                    populateTaskDropdown(tasks[projectId], projectId);
                }
            });
        }
        
        // Populate user dropdown
        function populateUserDropdown(users) {
            const assigneeSelect = document.getElementById('assignee');
            
            // Clear existing options
            assigneeSelect.innerHTML = '';
            
            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select a user';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            assigneeSelect.appendChild(defaultOption);
            
            // Add users
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.full_name;
                assigneeSelect.appendChild(option);
            });
        }
        
        // Populate task dropdown
        function populateTaskDropdown(tasks, projectId) {
            const taskSelect = document.getElementById('task-select');
            
            // Clear existing options
            taskSelect.innerHTML = '';
            
            // Add default "no task" option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'No task (post to project)';
            taskSelect.appendChild(defaultOption);
            
            // Sort tasks by title
            tasks.sort((a, b) => a.title.localeCompare(b.title));
            
            // Add tasks
            tasks.forEach(task => {
                const option = document.createElement('option');
                option.value = task.id;
                option.textContent = task.title;
                taskSelect.appendChild(option);
            });
        }
        
        // Generate Task Command
        document.getElementById('generate-task-cmd').addEventListener('click', () => {
            const projectId = document.getElementById('project-select-task').value;
            const taskName = document.getElementById('task-name').value.trim();
            const description = document.getElementById('task-description').value.trim();
            const startDate = document.getElementById('start-date').value;
            const dueDate = document.getElementById('due-date').value;
            const assigneeId = document.getElementById('assignee').value;
            
            if (!projectId) {
                showMessage('task-message', 'Please select a project', 'error');
                return;
            }
            
            if (!taskName) {
                showMessage('task-message', 'Please enter a task name', 'error');
                return;
            }
            
            // Build JSON payload
            const taskData = {
                story: {
                    title: taskName,
                    description: description,
                    workspace_id: projectId,
                    story_type: 'task'
                }
            };
            
            if (startDate) {
                taskData.story.start_date = startDate;
            }
            
            if (dueDate) {
                taskData.story.due_date = dueDate;
            }
            
            if (assigneeId) {
                taskData.story.assignee_id = assigneeId;
            }
            
            // Create curl command
            const taskCommand = document.getElementById('task-command');
            taskCommand.value = `curl -H "Authorization: Bearer ${apiToken}" \\
  -H "Content-Type: application/json" \\
  -X POST "https://api.mavenlink.com/api/v1/stories" \\
  -d '${JSON.stringify(taskData)}'`;
            
            showMessage('task-message', 'Command generated. Copy and run it to create the task.', 'success');
        });
        
        // Copy Task Command
        document.getElementById('copy-task-cmd').addEventListener('click', () => {
            const taskCommand = document.getElementById('task-command');
            taskCommand.select();
            document.execCommand('copy');
            showMessage('task-message', 'Command copied to clipboard', 'success');
        });
        
        // Generate Time Command
        document.getElementById('generate-time-cmd').addEventListener('click', () => {
            const projectId = document.getElementById('project-select-time').value;
            const taskId = document.getElementById('task-select').value;
            const date = document.getElementById('date').value;
            const hours = document.getElementById('time-hours').value;
            const notes = document.getElementById('time-notes').value.trim();
            
            if (!projectId) {
                showMessage('time-message', 'Please select a project', 'error');
                return;
            }
            
            if (!date) {
                showMessage('time-message', 'Please select a date', 'error');
                return;
            }
            
            if (!hours || isNaN(parseFloat(hours)) || parseFloat(hours) <= 0) {
                showMessage('time-message', 'Please enter valid hours', 'error');
                return;
            }
            
            // Build JSON payload
            const timeEntryData = {
                time_entry: {
                    workspace_id: projectId,
                    date_performed: date,
                    time_in_minutes: Math.round(parseFloat(hours) * 60),
                    notes: notes
                }
            };
            
            if (taskId) {
                timeEntryData.time_entry.story_id = taskId;
            }
            
            // Create curl command
            const timeCommand = document.getElementById('time-command');
            timeCommand.value = `curl -H "Authorization: Bearer ${apiToken}" \\
  -H "Content-Type: application/json" \\
  -X POST "https://api.mavenlink.com/api/v1/time_entries" \\
  -d '${JSON.stringify(timeEntryData)}'`;
            
            showMessage('time-message', 'Command generated. Copy and run it to post time.', 'success');
        });
        
        // Copy Time Command
        document.getElementById('copy-time-cmd').addEventListener('click', () => {
            const timeCommand = document.getElementById('time-command');
            timeCommand.select();
            document.execCommand('copy');
            showMessage('time-message', 'Command copied to clipboard', 'success');
        });
        
        // Helper function to show success/error messages
        function showMessage(elementId, message, type) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.className = type === 'success' ? 'success-message' : 
                               type === 'info' ? 'info-message' : 'error-message';
            
            // Clear message after 8 seconds
            setTimeout(() => {
                element.textContent = '';
                element.className = '';
            }, 8000);
        }
    </script>
</body>
</html>