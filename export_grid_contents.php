<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Export Tool</title>
    <style type="text/css">
        body, html { height:100%; font-family: Arial, sans-serif; }
         body { 
            font-family: "Figtree", sans-serif; 
            background-image: url('/images/treebg.png');
            background-size: cover;      
            background-repeat: no-repeat; 
            background-position: center;  
            background-attachment: fixed;
            position:relative;
            height:100%;
        }
        h1 {
            font-family: Arial, sans-serif;
            font-size: 28px;
        }
        .footer { position: relative; margin: 0 auto 40px; max-width:1000px; }
        .footer a {     
            font-size: 12px;
            text-decoration: underline;
            color: #000;
            letter-spacing: .5px;
            display: inline-block;
            margin-right: 25px; 
        } 
        .content { max-width:1000px; margin:40px auto; word-wrap: break-word; min-height:80%; position:relative; }
        pre {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            cursor: pointer;
            margin: 10px 0;
        }
        pre:hover {
            background-color: #e8e8e8;
        }
        .copy-notice {
            display: none;
            color: green;
            margin-top: 5px;
            font-size: 14px;
        }
        .query-section {
            display: none;
            margin-top: 30px;
        }
        .query-title {
            font-weight: bold;
            margin: 20px 0 10px 0;
            font-size: 16px;
        }
        input[type="text"] {
            width: 300px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="checkbox"] {
            margin-right: 8px;
        }
        input[type="submit"] {
            background-color: #007cba;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #005a87;
        }
        .back-button {
            background-color: #666;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .back-button:hover {
            background-color: #555;
        }
        textarea {
            width: 100%;
            height: 150px;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: monospace;
            font-size: 12px;
        }
        .textarea-label {
            font-weight: bold;
            margin: 10px 0 5px 0;
            color: #333;
        }
        .secondary-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #ddd;
        }
        .final-queries {
            display: none;
            margin-top: 30px;
        }
        .final-query-title {
            font-weight: bold;
            margin: 20px 0 10px 0;
            font-size: 16px;
            color: #007cba;
        }
        .generate{
                    background: lightblue;
        
            border: 1px solid #888;
        
            padding: 5px 20px;
        
            border-radius: 7px;

        }
    </style>
</head>
<body>
    <div class="content">
        <div id="form-section">
            <h2>HTML Page Export Tool</h2>
            <form id="exportForm">
                <label for="html_id">Enter HTML ID:</label><br><br>
                <input type="text" id="html_id" name="html_id" placeholder="e.g. 60107" required>
                <br><br>
                <label>
                    <input type="checkbox" id="page_exists" name="page_exists">
                    This page already exists on the secondary site
                </label>
                <br><br>
                <label>
                    <input type="checkbox" id="is_email_template" name="is_email_template">
                    Is this an email template?
                </label>
                <br><br>
                <input type="submit" value="Generate Export Queries">

                <br /><br />
                <a href="#" id="help-link" style="color:#007cba;text-decoration:underline;cursor:pointer;">Help?</a>
                <div id="help-section" style="display:none; margin-top:20px;">
                    <p>The html_id value comes from the html table</p>
                    <img src="https://jessnunez.com/wp-content/uploads/2025/05/Screen-Shot-2025-05-28-at-9.37.47-PM.png" style="max-width:80%" />
                </div>
            </form>
        </div>

        <div id="query-section" class="query-section">
            <button class="back-button" onclick="showForm()">← Back to Form</button>
            <h2>Export Queries for HTML ID: <span id="display-html-id"></span></h2>
            
            <div id="email-template-section" style="display:none; margin-bottom:30px;">
                <div style="background:#f9f9f9; border:1px solid #ccc; padding:15px; border-radius:6px;">
                    <b>Navigate to email_templates</b> and copy the INSERT statement for the one you want to duplicate.<br><br>
                    <div class="textarea-label">Paste the INSERT statement here:</div>
                    <textarea id="email-template-insert" placeholder="Paste the INSERT statement from email_templates here..."></textarea>
                </div>
            </div>
            
            <div id="html-query" class="query-block">
                <div class="query-title">Export the page</div>
                <pre onclick="copyToClipboard(this)" id="html-sql"></pre>
                <div class="textarea-label">Paste query results here:</div>
                <textarea id="html-results" placeholder="Paste the results from the above query here..."></textarea>
            </div>
            
            <div class="query-title">Export All Content Blocks for the Page</div>
            <pre onclick="copyToClipboard(this)" id="contents-sql"></pre>
            <div class="textarea-label">Paste query results here:</div>
            <textarea id="contents-results" placeholder="Paste the results from the above query here..."></textarea>
            
            <div class="query-title">Export All Grids for the Page</div>
            <pre onclick="copyToClipboard(this)" id="grid-sql"></pre>
            <div class="textarea-label">Paste query results here:</div>
            <textarea id="grid-results" placeholder="Paste the results from the above query here..."></textarea>
            
            <div class="query-title">Export All Column Contents for the Page</div>
            <pre onclick="copyToClipboard(this)" id="column-contents-sql"></pre>
            <div class="textarea-label">Paste query results here:</div>
            <textarea id="column-contents-results" placeholder="Paste the results from the above query here..."></textarea>
            
            <div class="secondary-section">
                <h3>Step 2: Generate Import Queries</h3>
                <label for="secondary_html_id">Secondary Site HTML ID:</label><br><br>
                <input type="text" id="secondary_html_id" placeholder="e.g. 464" style="width:200px;">
                <br><br>
                <input type="button" value="Generate Import Queries" onclick="generateImportQueries()" class="generate">
            </div>
            
            <div id="final-queries" class="final-queries">
                <h3>Import Queries for Secondary Site</h3>
                
                <div id="final-html-query" class="query-block">
                    <div class="final-query-title">Import the page</div>
                    <pre onclick="copyToClipboard(this)" id="final-html-sql"></pre>
                </div>
                
                <div class="final-query-title">Import All Content Blocks for the Page</div>
                <pre onclick="copyToClipboard(this)" id="final-contents-sql"></pre>
                
                <div class="final-query-title">Import All Grids for the Page</div>
                <pre onclick="copyToClipboard(this)" id="final-grid-sql"></pre>
                
                <div class="final-query-title">Import All Column Contents for the Page</div>
                <pre onclick="copyToClipboard(this)" id="final-column-contents-sql"></pre>
                
                <div id="final-email-template-query" style="display:none;">
                    <div class="final-query-title">Email Template INSERT Statement</div>
                    <pre onclick="copyToClipboard(this)" id="final-email-template-sql"></pre>
                </div>
            </div>
            
            <div id="copyNotice" class="copy-notice">SQL copied to clipboard!</div>
        </div>
    </div>

    <script>
        // Function to copy SQL to clipboard
        function copyToClipboard(element) {
            var text = element.textContent;
            navigator.clipboard.writeText(text).then(function() {
                var notice = document.getElementById('copyNotice');
                notice.style.display = 'block';
                setTimeout(function() {
                    notice.style.display = 'none';
                }, 2000);
            });
        }

        // Handle form submission
        document.getElementById('exportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            var htmlId = document.getElementById('html_id').value.trim();
            var pageExists = document.getElementById('page_exists').checked;
            var isEmailTemplate = document.getElementById('is_email_template').checked;
            
            if (!htmlId || isNaN(htmlId)) {
                alert('Please enter a valid HTML ID (numeric value)');
                return;
            }
            
            // Generate the SQL queries
            generateQueries(htmlId, pageExists);
            
            // Show the query section and hide the form
            document.getElementById('form-section').style.display = 'none';
            document.getElementById('query-section').style.display = 'block';
            // Show/hide email template section
            document.getElementById('email-template-section').style.display = isEmailTemplate ? 'block' : 'none';
        });

        function generateQueries(htmlId, pageExists) {
            // Update the display HTML ID
            document.getElementById('display-html-id').textContent = htmlId;
            
            // Generate SQL queries
            var htmlQuery = `SELECT * FROM html WHERE html_id = ${htmlId};`;
            var contentsQuery = `SELECT * FROM html_contents WHERE html_contents_html_id = ${htmlId};`;
            var gridQuery = `SELECT * FROM html_column_grid WHERE html_column_grid_html_id = ${htmlId};`;
            var columnContentsQuery = `SELECT * FROM html_column_contents WHERE html_column_contents_html_id = ${htmlId};`;
            
            // Set the SQL content
            document.getElementById('html-sql').textContent = htmlQuery;
            document.getElementById('contents-sql').textContent = contentsQuery;
            document.getElementById('grid-sql').textContent = gridQuery;
            document.getElementById('column-contents-sql').textContent = columnContentsQuery;
            
            // Hide the html query if page already exists
            if (pageExists) {
                document.getElementById('html-query').style.display = 'none';
            } else {
                document.getElementById('html-query').style.display = 'block';
            }
        }

        function showForm() {
            document.getElementById('form-section').style.display = 'block';
            document.getElementById('query-section').style.display = 'none';
            // Reset form
            document.getElementById('exportForm').reset();
        }

        // Track old-to-new ID mappings for reference updates
        function buildIdMap(queryResult) {
            const idMap = {};
            if (!queryResult) return idMap;
            queryResult.replace(/\(([^)]+)\)/g, function(match, rowContent) {
                let values = [];
                let current = '';
                let inQuotes = false;
                let quoteChar = '';
                for (let i = 0; i < rowContent.length; i++) {
                    let char = rowContent[i];
                    if ((char === '\'' || char === '"') && (!inQuotes || char === quoteChar)) {
                        if (inQuotes && char === quoteChar) {
                            inQuotes = false;
                        } else if (!inQuotes) {
                            inQuotes = true;
                            quoteChar = char;
                        }
                        current += char;
                    } else if (char === ',' && !inQuotes) {
                        values.push(current.trim());
                        current = '';
                    } else {
                        current += char;
                    }
                }
                values.push(current.trim());
                // Only map if first value is a number and not quoted
                if (values.length > 0 && !/^['"]/.test(values[0]) && /^\d+$/.test(values[0])) {
                    const oldId = values[0];
                    const newId = oldId + '000';
                    idMap[oldId] = newId;
                }
                return match;
            });
            return idMap;
        }

        function replaceHtmlIdWithReferences(queryResult, originalId, newId, idMap) {
            if (!queryResult) return '';
            return queryResult.replace(/\(([^)]+)\)/g, function(match, rowContent) {
                let values = [];
                let current = '';
                let inQuotes = false;
                let quoteChar = '';
                for (let i = 0; i < rowContent.length; i++) {
                    let char = rowContent[i];
                    if ((char === '\'' || char === '"') && (!inQuotes || char === quoteChar)) {
                        if (inQuotes && char === quoteChar) {
                            inQuotes = false;
                        } else if (!inQuotes) {
                            inQuotes = true;
                            quoteChar = char;
                        }
                        current += char;
                    } else if (char === ',' && !inQuotes) {
                        values.push(current.trim());
                        current = '';
                    } else {
                        current += char;
                    }
                }
                values.push(current.trim());

                // Update first value (ID)
                if (values.length > 0 && !/^['"]/.test(values[0]) && /^\d+$/.test(values[0])) {
                    const oldId = values[0];
                    if (idMap[oldId]) {
                        values[0] = idMap[oldId];
                    }
                }
                // Always set the second value to the new HTML ID
                if (values.length > 1) {
                    values[1] = newId;
                }
                // Update all other values that are IDs in the idMap
                for (let i = 2; i < values.length; i++) {
                    let val = values[i].replace(/^['"]|['"]$/g, '');
                    if (idMap[val]) {
                        values[i] = values[i].replace(val, idMap[val]);
                    }
                }
                return '(' + values.join(', ') + ')';
            });
        }

        // In generateImportQueries, build the idMap from the relevant query results and use replaceHtmlIdWithReferences
        function generateImportQueries() {
            var secondaryHtmlId = document.getElementById('secondary_html_id').value.trim();
            var originalHtmlId = document.getElementById('display-html-id').textContent;
            var pageExists = document.getElementById('page_exists').checked;
            var isEmailTemplate = document.getElementById('is_email_template') ? document.getElementById('is_email_template').checked : false;
            
            if (!secondaryHtmlId || isNaN(secondaryHtmlId)) {
                alert('Please enter a valid Secondary Site HTML ID (numeric value)');
                return;
            }
            
            // Get textarea contents
            var htmlResults = document.getElementById('html-results').value.trim();
            var contentsResults = document.getElementById('contents-results').value.trim();
            var gridResults = document.getElementById('grid-results').value.trim();
            var columnContentsResults = document.getElementById('column-contents-results').value.trim();
            var emailTemplateInsert = '';
            if (isEmailTemplate) {
                emailTemplateInsert = document.getElementById('email-template-insert').value.trim();
            }
            
            // Build ID map from all relevant queries
            var idMap = {};
            Object.assign(idMap, buildIdMap(contentsResults));
            Object.assign(idMap, buildIdMap(gridResults));
            Object.assign(idMap, buildIdMap(columnContentsResults));
            // (html table usually doesn't need this, but can be added if needed)

            // Process each query result and replace html_id values using reference-aware replacement
            var finalHtmlSql = '';
            var finalContentsSql = '';
            var finalGridSql = '';
            var finalColumnContentsSql = '';
            
            if (htmlResults && !pageExists) {
                // If the pasted SQL is for html_contents, use the robust replacement
                if (/insert into\s+html_contents/i.test(htmlResults)) {
                    finalHtmlSql = replaceHtmlIdWithReferences(htmlResults, originalHtmlId, secondaryHtmlId, idMap);
                } else {
                    finalHtmlSql = processHtmlQuery(htmlResults, originalHtmlId, secondaryHtmlId);
                }
                document.getElementById('final-html-sql').textContent = finalHtmlSql;
            }
            
            if (contentsResults) {
                finalContentsSql = replaceHtmlIdWithReferences(contentsResults, originalHtmlId, secondaryHtmlId, idMap);
                document.getElementById('final-contents-sql').textContent = finalContentsSql;
            }
            
            if (gridResults) {
                finalGridSql = replaceHtmlIdWithReferences(gridResults, originalHtmlId, secondaryHtmlId, idMap);
                document.getElementById('final-grid-sql').textContent = finalGridSql;
            }
            
            if (columnContentsResults) {
                finalColumnContentsSql = replaceHtmlIdWithReferences(columnContentsResults, originalHtmlId, secondaryHtmlId, idMap);
                document.getElementById('final-column-contents-sql').textContent = finalColumnContentsSql;
            }
            // Show/hide the email template insert result
            if (isEmailTemplate && emailTemplateInsert) {
                document.getElementById('final-email-template-query').style.display = 'block';
                document.getElementById('final-email-template-sql').textContent = emailTemplateInsert;
            } else if (document.getElementById('final-email-template-query')) {
                document.getElementById('final-email-template-query').style.display = 'none';
            }
            
            // Show/hide the appropriate sections
            if (pageExists) {
                document.getElementById('final-html-query').style.display = 'none';
            } else {
                document.getElementById('final-html-query').style.display = 'block';
            }
            
            // Show the final queries section
            document.getElementById('final-queries').style.display = 'block';
        }

        function processHtmlQuery(queryResult, originalId, newId) {
            if (!queryResult) return '';

            // Remove the SELECT if present
            var insertSql = queryResult.replace(/SELECT \* FROM html WHERE html_id = \d+;?/i, '');

            // Replace the second value in the VALUES row with the new HTML ID
            return insertSql.replace(/\(([^)]+)\)/g, function(match, rowContent) {
                let values = [];
                let current = '';
                let inQuotes = false;
                let quoteChar = '';
                for (let i = 0; i < rowContent.length; i++) {
                    let char = rowContent[i];
                    if ((char === '\'' || char === '"') && (!inQuotes || char === quoteChar)) {
                        if (inQuotes && char === quoteChar) {
                            inQuotes = false;
                        } else if (!inQuotes) {
                            inQuotes = true;
                            quoteChar = char;
                        }
                        current += char;
                    } else if (char === ',' && !inQuotes) {
                        values.push(current.trim());
                        current = '';
                    } else {
                        current += char;
                    }
                }
                values.push(current.trim());

                // Always set the second value to the new HTML ID
                if (values.length > 1) {
                    values[1] = newId;
                }
                return '(' + values.join(', ') + ')';
            });
        }

        function processContentsQuery(queryResult, originalId, newId) {
            if (!queryResult) return '';
            
            // First try specific pattern replacement for VALUES clause
            var regex1 = new RegExp('(VALUES\\s*\\(\\s*\\d+\\s*,\\s*)' + originalId + '(\\s*,)', 'g');
            var result = queryResult.replace(regex1, '$1' + newId + '$2');
            
            // Fallback: replace any standalone instances of the original ID
            var regex2 = new RegExp('\\b' + originalId + '\\b', 'g');
            result = result.replace(regex2, newId);
            
            return result;
        }

        function processGridQuery(queryResult, originalId, newId) {
            if (!queryResult) return '';
            
            // First try specific pattern replacement for VALUES clause
            var regex1 = new RegExp('(VALUES\\s*\\(\\s*\\d+\\s*,\\s*)' + originalId + '(\\s*,)', 'g');
            var result = queryResult.replace(regex1, '$1' + newId + '$2');
            
            // Fallback: replace any standalone instances of the original ID
            var regex2 = new RegExp('\\b' + originalId + '\\b', 'g');
            result = result.replace(regex2, newId);
            
            return result;
        }

        function processColumnContentsQuery(queryResult, originalId, newId) {
            if (!queryResult) return '';
            
            // First try specific pattern replacement for VALUES clause
            var regex1 = new RegExp('(VALUES\\s*\\(\\s*\\d+\\s*,\\s*)' + originalId + '(\\s*,)', 'g');
            var result = queryResult.replace(regex1, '$1' + newId + '$2');
            
            // Fallback: replace any standalone instances of the original ID
            var regex2 = new RegExp('\\b' + originalId + '\\b', 'g');
            result = result.replace(regex2, newId);
            
            return result;
        }

        // Toggle help section
        document.addEventListener('DOMContentLoaded', function() {
            var helpLink = document.getElementById('help-link');
            var helpSection = document.getElementById('help-section');
            if (helpLink && helpSection) {
                helpLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (helpSection.style.display === 'none') {
                        helpSection.style.display = 'block';
                    } else {
                        helpSection.style.display = 'none';
                    }
                });
            }
        });
    </script>
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
