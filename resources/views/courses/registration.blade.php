@extends('layouts.app')

@section('title', 'Регистрация на курсы')

@section('content')
    <h1 class=" mt-6 text-primary text-2xl sm:text-4xl">Регистрация на курсы</h1>

    <div class="text-sm sm:text-base mt-6">
        <form id="feedback_form" class="feedback_form" action="/web/20170506063157/http://www.pipaa.tj/ru/feedback/index/pageId/55/" method="post">
            <dl>



                <dt><div class="red">*</div><label for="departure_point">Название курса </label></dt>
                <dd><input type="text" name="departure_point" size="50" maxlength="50"/></dd>

                <dt><div class="red">*</div><label for="arrival_point">Дата прохождения курса </label></dt>
                <dd><input type="text" name="arrival_point" size="50" maxlength="50"/></dd>

                <dt><div class="red">*</div><label for="fullname">ФИО</label></dt>
                <dd><input type="text" name="fullname" size="50" maxlength="50"/></dd>


                <dt><div class="red">*</div><label for="phone">Телефон</label></dt>
                <dd><input type="text" name="phone" size="50" maxlength="50"/></dd>


                <dt><div class="red">*</div><label for="email">Email</label></dt>
                <dd><input type="text" name="email" size="50" maxlength="100"/></dd>



                <div class="clear"></div>


                <dt><div class="red">*</div><label for="message">Ваше сообщение</label></dt>
                <dd><textarea name="message" rows="2" cols="38"></textarea></dd>




                <dt><label for="code">Код</label></dt>
                <dd>
                    <input type="text" name="code_text" id="code_text" maxlength="6" size="6"/>
                    <img src="/web/20170506063157im_/http://www.pipaa.tj/ru/feedback/get-captcha?id=8636" align="top" id="code_image" style="border: solid 1px #000000;"/>
                </dd>

                <dt>&nbsp;</dt>
                <dd>
                    <input type="submit" value="Отправить"/>
                    <input type="reset" value="Очистить">
                </dd>
                <div class="clear"></div>
                <hr size="1" noshade>
                <p><div class="red">*</div>Необходиые поля / Required fields</h2>
            </dl>

        </form>


    </div>

@endsection
