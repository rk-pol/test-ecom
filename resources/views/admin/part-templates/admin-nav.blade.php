<div class="flex flex-dr-col admin-nav flex-jst-c">
    <table class="admin-nav-tbl">
        <tbody>
            <tr>
                <td class="admin-nav-title" >
                    <a href="{{ URL('/admin') }}">Main</a>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="admin_nav_create" class="admin-nav-title">
                        Create
                        <div class="admin-list flex elem-hidden">
                            <ul>
                                <li>
                                    <a href="{{ URL('/admin/product') }}">
                                        Product
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ URL('/admin/animal') }}">
                                        Animal
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ URL('/admin/provider') }}">
                                        Provider
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>   
                    
                </td>
            </tr>
        </tbody>
    </table>
</div>
