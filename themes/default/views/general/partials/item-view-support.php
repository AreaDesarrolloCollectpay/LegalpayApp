<?php if($file['type'] == 1){ ?>
    <iframe src="https://docs.google.com/gview?url=<?php echo $file['file']; ?>&embedded=true" style="width:100%; height:375px;" frameborder="0"></iframe>
<?php }else{ ?>
    <img class="materialboxed img_detail_support" width="50%" src="<?php echo $file['file']; ?>">    
<?php } ?>



