    <div class="mainContent">
        <div class="addItem">
            <div class="message"><? ?></div>
            <form class="addClass" action="<?= BASE_URL; ?>/index.php?controller=admin&action=categories" method="post">
                <input class="input" type="text" name="name" autocomplete="off" placeholder="Название">
                <input class="inputBtn mFont" type="submit" value="Добавить">
            </form>
        </div>
        <form action="" class="dishForm">
            <table class="dishContent">
                <thead>
                <tr>
                    <th>#</th>
                    <th>№</th>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 0; $i < count($categories); $i++): ?>
                    <tr>
                        <td><input type="checkbox" name="id_categories[]" value="<?= $categories[$i]['category_id']; ?>"></td>
                        <td><?= ($i + 1 + (($current_page - 1) * $categories_per_page)); ?></td>
                        <td><?= $categories[$i]['category_name']; ?></td>
                        <td>
                            <a class="adminLink"
                               href="<?= BASE_URL; ?>/index.php?controller=admin&action=editCategory&id=<?= $categories[$i]['category_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     viewBox="0 0 26 26" version="1.1"
                                     width="26px" height="26px">
                                    <g id="surface1">
                                        <path class="adminButton"
                                              d="M 20.09375 0.25 C 19.5 0.246094 18.917969 0.457031 18.46875 0.90625 L 17.46875 1.9375 L 24.0625 8.5625 L 25.0625 7.53125 C 25.964844 6.628906 25.972656 5.164063 25.0625 4.25 L 21.75 0.9375 C 21.292969 0.480469 20.6875 0.253906 20.09375 0.25 Z M 16.34375 2.84375 L 14.78125 4.34375 L 21.65625 11.21875 L 23.25 9.75 Z M 13.78125 5.4375 L 2.96875 16.15625 C 2.71875 16.285156 2.539063 16.511719 2.46875 16.78125 L 0.15625 24.625 C 0.0507813 24.96875 0.144531 25.347656 0.398438 25.601563 C 0.652344 25.855469 1.03125 25.949219 1.375 25.84375 L 9.21875 23.53125 C 9.582031 23.476563 9.882813 23.222656 10 22.875 L 20.65625 12.3125 L 19.1875 10.84375 L 8.25 21.8125 L 3.84375 23.09375 L 2.90625 22.15625 L 4.25 17.5625 L 15.09375 6.75 Z M 16.15625 7.84375 L 5.1875 18.84375 L 6.78125 19.1875 L 7 20.65625 L 18 9.6875 Z "/>
                                    </g>
                                </svg>
                            </a>
                            <a class="adminLink deleteButton"
                               href="<?= BASE_URL; ?>/index.php?controller=admin&action=deleteCategory&id=<?= $categories[$i]['category_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     viewBox="0 0 26 26" version="1.1"
                                     width="26px" height="26px">
                                    <g id="trash">
                                        <path class="adminButton"
                                              d="M 11 -0.03125 C 10.164063 -0.03125 9.34375 0.132813 8.75 0.71875 C 8.15625 1.304688 7.96875 2.136719 7.96875 3 L 4 3 C 3.449219 3 3 3.449219 3 4 L 2 4 L 2 6 L 24 6 L 24 4 L 23 4 C 23 3.449219 22.550781 3 22 3 L 18.03125 3 C 18.03125 2.136719 17.84375 1.304688 17.25 0.71875 C 16.65625 0.132813 15.835938 -0.03125 15 -0.03125 Z M 11 2.03125 L 15 2.03125 C 15.546875 2.03125 15.71875 2.160156 15.78125 2.21875 C 15.84375 2.277344 15.96875 2.441406 15.96875 3 L 10.03125 3 C 10.03125 2.441406 10.15625 2.277344 10.21875 2.21875 C 10.28125 2.160156 10.453125 2.03125 11 2.03125 Z M 4 7 L 4 23 C 4 24.652344 5.347656 26 7 26 L 19 26 C 20.652344 26 22 24.652344 22 23 L 22 7 Z M 8 10 L 10 10 L 10 22 L 8 22 Z M 12 10 L 14 10 L 14 22 L 12 22 Z M 16 10 L 18 10 L 18 22 L 16 22 Z "/>
                                    </g>
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </form>
        <div class="pagination">
            <?php if ($current_page == 1):?>
                <span class="pagination_link disable">Пред</span>
            <?php else:?>
                <a class="pagination_link"
                   href="<?= BASE_URL;?>/index.php?controller=admin&action=categories&page=<?= $current_page - 1;?>">Пред
                </a>
            <?php endif;?>
            <?php for ($i = 0; $i < $pages_count; $i++):?>
                <a class="pagination_link <?php if (($i + 1) == $current_page) echo 'active'?>"
                   href="<?= BASE_URL;?>/index.php?controller=admin&action=categories&page=<?= ($i + 1);?>">
                    <?= ($i + 1);?>
                </a>
            <?php endfor;?>
            <?php if ($current_page == $pages_count):?>
                <span class="pagination_link disable">След</span>
            <?php else:?>
                <a class="pagination_link"
                   href="<?= BASE_URL;?>/index.php?controller=admin&action=categories&page=<?= $current_page + 1;?>">След
                </a>
            <?php endif;?>
        </div>
    </div>
</div>