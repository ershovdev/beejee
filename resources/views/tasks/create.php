<form action="/tasks/add" method="post" class="col-md-4">
    <div class="form-group">
        <label for="task_username">Username</label>
        <input type="text"
               id="task_username"
               class="form-control"
               name="username"
               placeholder="Enter username" />
    </div>
    <div class="form-group">
        <label for="task_email">Email address</label>
        <input type="email" id="task_email" class="form-control" name="email" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="task_text">Text</label>
        <textarea name="text" id="task_text" class="form-control" cols="30" rows="10"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
