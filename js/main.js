
	
function changeImg(img,type)
{
	b = new Image;
	b.src="img/"+img+type+".jpg";
  document[img].src=b.src;	
}

function changeImg2(img)
{
	b = new Image;
	b.src="img/"+img+".jpg";
  document['index3_r3_c7'].src=b.src;	
}


function eliminar(id,cat)
{
	confirm('¿Realmente desea eliminar esta noticia?');
		location.replace("news.php?borrar="+id+"&cat="+cat);	
}

function openFc(cat){window.open('manage.php?cat='+cat,'','toolbar=0,location=0,directories=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=700,height=560,left=20,top=30')}

function openFc2(id,cat){window.open('manage.php?cat='+cat+'&id='+id,'','toolbar=0,location=0,directories=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=700,height=560,left=20,top=30')}