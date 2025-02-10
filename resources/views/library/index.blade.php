@extends('layouts.app')

@section('title', 'Библиотека')

@section('content')
    <h1 class=" mt-6 text-primary text-2xl sm:text-4xl">Библиотека</h1>
    <div class="text-sm sm:text-base mt-6">
        <table width="80%" cellspacing="1" cellpadding="1" border="0">
            <tbody>
            <tr>
                <td><img width="345" height="255" src="https://picsum.photos/500/400" alt=""/>&nbsp; &nbsp;&nbsp;</td>
                <td>
                    <ul>
                        <li><a href="/web/20180901025203/http://pipaa.tj/ru/index/index/pageId/70/">Нормативные документы</a></li>
                        <li><a href="/web/20180901025203/http://pipaa.tj/ru/index/index/pageId/29/">Книги</a></li>
                        <li><a href="/web/20180901025203/http://pipaa.tj/ru/index/index/pageId/30/">Курсовые/рефераты</a></li>
                        <li><a href="/web/20180901025203/http://pipaa.tj/ru/index/index/pageId/31/">Дипломные работы</a></li>
                        <li><a href="/web/20180901025203/http://pipaa.tj/ru/index/index/pageId/98/">Материалы для экзамена CAP/CIPA</a></li>
                        <li><a href="/web/20180901025203/http://pipaa.tj/ru/index/index/pageId/32/">Полезные ссылки</a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</li>
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
