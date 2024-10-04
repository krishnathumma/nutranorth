<?php 

if(strtolower($type) == 'add'){
    $subject = 'Task ID ('.$task->id.') Added';
    $assign_by = "Task Assigned By";
    $tag = "Task has been Added";
    $emailId = $user->email;
} else if(strtolower($type) == 'edit'){
    $subject = 'Task ID ('.$task->id.') Updated';
    $assign_by = "Task Assigned By";
    $tag = "Task has been Added";
    $emailId = $user->email;
} else {
    $subject = 'Task ID ('.$task->id.') Status Changed';
    $assign_by = "Task Updated By";
    $tag = "Task Status Changed";
    $emailId = $task_assigned->email;
}

$url = "Thanks<br/>Nutra North";
$htmlheader = '<!doctype html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport"
                            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">

                        <style>
                            p {
                                font-size: 12px;
                            }

                            .signature {
                                font-style: italic;
                            }
                        </style>
                    </head>';

if(strtolower($type) == 'add' || strtolower($type) == 'edit'){
    $htmlbody  ='<body>
      <div style="font-size:13px;line-height:1.4;margin:0;padding:0">
        <div style="background:#f7f7f7;font:13px; "Proxima Nova","Helvetica Neue",Arial,sans-serif;padding:2% 7%">
          <div style="background:#fff;border-top-color:#ffa800;border-top-style:solid;border-top-width:4px;margin:25px auto">
            <div style="border-color:#e5e5e5;border-style:none solid solid;border-width:2px;padding:7%">
              <p style="color:#333;font-size:14px;line-height:1.4;margin:0 0 20px">Hello '.$user_name.',</p>
              <p style="color:#333;font-size:13px;line-height:1.4;margin:20px 0">
                '.$tag.'<br />
                Task ID: '.$task->id.' <br />
                Task Category: '.ucfirst($task->task_category).' <br />
                Task Type: '.ucfirst($task->task_type).' <br />
                Task Status: '.ucfirst($task->status).' <br />
                '.$assign_by.': '.$task_assigned_name.' <br />
                Task Assign Date: '.date("Y/m/d H:i:s A",strtotime($task->assigned_date)).' <br />
                Task Due Date: '.date("Y/m/d H:i:s A",strtotime($task->due_date)).' <br />
                Description: '.$task->description.'<br/>
              </p> 
              '.$url.'
            </div>
          </div>
        </div>
      </div>
    </body>';

} else {
    $updated_user = DB::table('users')->where('id', $task->updated_by)->first();
    $htmlbody  ='<body>
      <div style="font-size:13px;line-height:1.4;margin:0;padding:0">
        <div style="background:#f7f7f7;font:13px; "Proxima Nova","Helvetica Neue",Arial,sans-serif;padding:2% 7%">
          <div style="background:#fff;border-top-color:#ffa800;border-top-style:solid;border-top-width:4px;margin:25px auto">
            <div style="border-color:#e5e5e5;border-style:none solid solid;border-width:2px;padding:7%">
              <p style="color:#333;font-size:14px;line-height:1.4;margin:0 0 20px">Hello '.$task_assigned_name.',</p>
              <p style="color:#333;font-size:13px;line-height:1.4;margin:20px 0">
                '.$tag.'<br />
                Task ID: '.$task->id.' Status Changed to '.ucfirst($task->status).' on '.date("Y/m/d H:i:s A",strtotime($task->updated_at)).' by '.ucfirst($updated_user->name).'  <br />
              </p> 
              '.$url.'
            </div>
          </div>
        </div>
      </div>
    </body>';
}

$htmlfooter = '</html>';

$html = $htmlheader.$htmlbody.$htmlfooter;

?>