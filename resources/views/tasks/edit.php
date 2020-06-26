<form action="/tasks/<?php echo $task->getId(); ?>/edit" method="post" class="col-md-4">

    <div class="form-group">
        <label for="exampleInputEmail1">Text</label>
        <textarea name="text"
                  class="form-control"
                  cols="30"
                  rows="10"
                  ><?php
                                echo $task->getText();
                            ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
