function del_box(elm_id){
    let btn = document.getElementById("del-btn-"+elm_id);
    let box = document.getElementById("inp-box-"+elm_id);
    let pbb = document.getElementById("row-box-"+elm_id);
    let crd = document.getElementById("credit"+elm_id);
    
    pbb.parentNode.removeChild(pbb);
    crd.parentNode.removeChild(crd);
    btn.parentNode.removeChild(btn);
    box.parentNode.removeChild(box);
}