function set_val_data(id,url,target,form) {
    $("#"+target+"").show();
      $.get(""+url+"/"+id,(data)=>{
          $("#"+target+"").load(""+form+"",()=>{
            $.each(data,(ind,obj)=>{
                $("#"+ind).val(obj);
            });
          });
      },'json');
    return false;
}

function delete_row_data(id,url) {
    Swal.fire({
        title: 'Hapus Data?',
        text: "Data yang terhapus tidak dapat dikembalikan lagi",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.value) {
            $.get(""+url+"/"+id,(data)=>{
                if (data.code == '200') {
                    Swal.fire("Data Berhasil Dihapus!", "", "success");
                    location.reload(true);
                }else{
                    Swal.fire("GAGAL!", data.messages.error, "error");
                }
            },'json');
        }
    })
}