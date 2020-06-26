<form action="/tasks/add" method="post" class="col-md-4">
    <div class="form-group">
        <label for="exampleInputEmail1">Username</label>
        <input type="text"
               class="form-control"
               name="username"
               placeholder="Enter username" />
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" name="email" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Text</label>
        <textarea name="text" class="form-control" cols="30" rows="10"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
