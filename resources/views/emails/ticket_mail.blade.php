<!DOCTYPE html>
<html>
<head>
    <title>Test Email</title>
</head>
<body>
<h3>Hello </h3>
@if($details['type'] == 'admin')
    <p>Please check a new ticket ({{ $details['ticket_no'] }}) has been submitted by a customer.</p>
@elseif($details['type'] == 'customer')
    <p>Your ticket ({{ $details['ticket_no'] }}) has been closed by a admin.</p>
@endif
<p>Thank you!</p>
</body>
</html>
