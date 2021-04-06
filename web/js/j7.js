(jQuery)(function(){
    $('table.item-list .ui button.delete').click(function() {
        let $this=$(this),
            id=parseInt($this.parents('table.item-list tr')[0].id.replace(/i/, ''));
        if (id>0) {
            if ($this.hasClass('delete')) {
                if (confirm('Удаление приведёт к полному уничтожению данных. Если ты хочешь удалить информацию, то она больше никогда не будет тебе доступна. Это Чёрная дыра - возврата не будет'))
                {
                    $.post('products/delete/'+id, function(r){
                        console.log(r);
                        $this.parents('table.item-list tr').remove();
                    });
                }
                else {}
                
                
            }
        }
    });
    $('.product-info button.del-ing').click(function(){
        $(this).parent().remove();
    });
    $('.product-info button.add-ing').click(function() {
        let good=true;
        $(this).siblings().each(function(){
            if (this.value==0 || this.value=='') {
                $(this).addClass('error').focus(function(){$(this).removeClass('error')});
                good=false;
            }
        });
        if (good) {
            if ($(this).siblings().first().prop('tagName')=="SELECT") {
                let $ing=$(this).siblings().first().clone(),
                    $Ing=$(this).parent().clone();
                $ing.attr({'id': '', 'name':'Features[ingredient][]'}).val($(this).siblings().first().val()).children().first().remove();
                $Ing.children().last().remove();
                $Ing.children('#features-count').attr('name', 'Features[count][]');
                $Ing.append('<button type="button" class="del-ing"></button>').find('#features-ingredient').remove();
                $Ing.prepend($ing);
                $(this).siblings('input').val('');
                $(this).siblings('select').val(0);
                $(this).siblings('span').text('');
                $(this).parent().before($Ing);
            }
            else if ($(this).siblings().first().prop('tagName')=="INPUT") {
                $(this).parent().after($Ing);
            }
        }
    });
    $('.product-info button.add-ing-new').click(function() {
        let $ing=$('#features-ingredient');
        $Ing=$('#features-ingredient').parent().clone();
        $ing.after('<input class="ingre" value="" name="Ingredients[title][]">')
            .next().next().attr('name', 'Features[count][]')
            .next().text('').after('<input class="diment" name=Ingredients[dimention][]" >');
        $('input.ingre').last().focus();
        $ing.remove();
    });

    $('.ingredient select').change(function() {
        if (this.value) {
            $(this).siblings('span.diment').text($dimentions[this.value]);
        }
    });
    $('.toolbar .search').keyup(function(e) {
                console.log(e);
        $("#searchlist").remove();
        if($(this).val().length>3) {
            $this = $(this);
            if (e.keyCode==13) document.location.href='products/search?query='+this.value;
            $this.after('<div id="searchlist"><ul></ul></div>');
            $.post('products/search', {'query': this.value}, function(res) {
                JSON.parse(res).forEach(function(i, e) {
                    $('#searchlist ul').append('<li><a href="products/'+i.id+'">'+i.title+'</a></li>');
                });
            });
        }
    });

    $("#items-img").change(function () {
        readURL(this);
    });
    $('.stand button#create').click(function() {
        let $this = $(this);
        let data = encodeURI($this.siblings('textarea').val().replace(/\r?\n/g, ""));
        $.post('api/products/', data, function(req) {
            $this.siblings('#post-create.request').text(req);
            console.log(req);
        })
    });
    $('.stand button#update').click(function() {
        let $this = $(this);
        let data = encodeURI($this.siblings('textarea').val().replace(/\r?\n/g, ""));
        $.ajax({
            url:'api/products/1',
            type: 'PUT',
            data: data,
            dataType: 'json'
        }).done(function(e) {
            $this.siblings('#post-update.request').text(JSON.stringify(e));
        }).always(function(e) {
            console.log(e.responseText);
        });
    });
    $('.stand button#delete').click(function() {
        let $this = $(this);
        let id = $this.siblings().find('select#items-list').val();
        let $fthis = $this.clone();
        if (!$this.hasClass('confirm')) {
            $this.addClass('confirm')
                .text('Подтвердить');
            return false;
        }
        
        $.ajax({
            url:'api/products/'+id,
            type: 'DELETE',
            dataType: 'json'
        }).done(function(e) {
            $this.siblings('#delete-del.request').text(e.message);
        }).always(function(e) {
            console.log(e/*.responseText*/);
        });
        $this.removeClass('confirm').text('Отправить');
        
    });

});

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.i-img img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
