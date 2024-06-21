(function() {
    function pluginGrapes(editor, opts = {}) {
        const options = {
            tailwindCss: opts.tailwindCss || 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css',
            prismCss: opts.prismCss || 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.28.0/themes/prism.min.css',
            prismJs: opts.prismJs || 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.28.0/prism.min.js',
            flowbetJs: opts.flowbetJs || 'https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js',
            flowbetCss: opts.flowbetCss || 'https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css',
            apiUrl: opts.apiUrl,
            apiUrlPages: opts.apiUrlPages,
            urlStore: opts.urlStore,
            csrfToken: opts.csrfToken,
            urlDestroyPage: opts.urlDestroyPage,
            urlUpdateNamePage: opts.urlUpdateNamePage,
            urlSaveProjects: opts.urlSaveProjects,
            ...opts
        };

        async function fetchBlocks() {
            try {
                const response = await fetch(`${options.apiUrl}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const blocks = await response.json();
                registerBlocks(blocks);
            } catch (error) {
                console.error('Failed to fetch blocks:', error);
            }
        }

        async function fetchPages() {
            try {
                const response = await fetch(`${options.apiUrlPages}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                $('#wrapperPages').html('');
                const pages = await response.json();
                registerPages(pages);
            } catch (error) {
                console.error('Failed to fetch pages:', error);
            }
        }

        function registerBlocks(blocks) {
            const $blocks = editor.BlockManager;
            blocks.forEach(block => {
                $blocks.add(block.id, {
                    label: block.label,
                    content: block.content,
                    category: block.category
                });
            });
        }

        function storePage(param) {
            return new Promise((resolve, reject) => {
                $.post(options.urlStore, {...param})
                .done(function(response) {
                    resolve(response);
                }).fail(err => {
                    reject(err);
                })
            })
        }

        function destroyPage({id, _token}) {
            return new Promise((resolve, reject) => {
                $.post(options.urlDestroyPage, {
                    id,
                    _token
                })
                .done(function(response) {
                    resolve(response);
                }).fail(err => {
                    reject(err);
                })
            })
        }

        function updateNamePage({id, title, _token}) {
            return new Promise((resolve, reject) => {
                $.post(options.urlUpdateNamePage, {
                    id,
                    title,
                    _token
                })
                .done(function(response) {
                    resolve(response);
                }).fail(err => {
                    reject(err);
                })
            })
        }

        function saveProject({pages, _token}) {
            return new Promise((resolve, reject) => {
                $.post(options.urlSaveProjects, {
                    pages,
                    _token
                })
                .done(function(response) {
                    resolve(response);
                }).fail(err => {
                    reject(err);
                })
            })
        }

        function filterCssForComponent(css, component) {
            const componentId = component.getId();
            const regex = new RegExp(`#${componentId}`, 'g');
            return css.split('\n').filter(line => regex.test(line)).join('\n');
        }

        function registerPages(pages) {
            const $pages = editor.Pages;
            pages.map((page, index) => {
                $('#wrapperPages').append(`
                    <li data-id-page="${page.id}" class="mb-2 hover:bg-opacity-20 hover:bg-slate-50 bg-opacity-30 relative rounded-lg ${(index == 0 ? 'bg-slate-50' : '')} flex justify-center items-center">
                        <button 
                            data-id-page="${page.id}" 
                            class="w-full h-full text-slate-50 px-3 py-2 text-start text-sm selectpage"
                        >
                            <input title="${page.title}" type="text" readonly class="bg-transparent text-sm truncate hover:cursor-pointer inputNamaPage${page.id} h-[20px] w-[100px] focus:ring-0 outline-none border-none" value="${page.title}" />
                        </button>
                        <div class="absolute flex justify-center items-center w-max gap-2 right-4">
                            <button 
                                type="button" 
                                class="editNamePage text-slate-50 hover:opacity-60"
                                title="Edit Name Page"
                                data-id-page="${page.id}"
                            ><i data-id-page="${page.id}" class="ri-pencil-line"></i></button>
                            <button 
                                type="button" 
                                class="copyPage text-slate-50 hover:opacity-60"
                                title="Copy Page"
                                data-id-page="${page.id}"
                            ><i data-id-page="${page.id}" class="ri-file-copy-2-line"></i></button>
                            <button 
                                type="button" 
                                class="deletePage text-slate-50 hover:opacity-60"
                                title="Delete Page"
                                data-id-page="${page.id}"
                            ><i data-id-page="${page.id}" class="ri-delete-bin-line"></i></button>
                        </div>
                    </li>
                `)

                $pages.add({
                    id: page.id,
                    name: page.title,
                    styles: page.style,
                    component: page.content
                });

            });
            
            const page = $pages.get(pages[0].id);
            $pages.select(page);

            const selectPage = $('.selectpage');
            const copyPage = $('.copyPage');
            const deletePage = $('.deletePage');
            const editNamePage = $('.editNamePage');
            $.each(selectPage, function(index, value) {
                $(value).click(function (event) {
                    for(let select of selectPage) {
                        $(select).parent().removeClass('bg-slate-50');
                    }
                    $(this).parent().addClass('bg-slate-50');
                    const idPage = $(this).attr('data-id-page');
                    const $pg = editor.Pages;
                    const getPage = $pg.get(parseInt(idPage));
                    $pg.select(getPage);
                })
            });

            $.each(copyPage, function(index, value) {
                $(value).click(function (event) {
                    const idPage = $(this).attr('data-id-page');
                    editor.runCommand('copy-page', {
                        id: parseInt(idPage),
                        success: (response => {
                            console.log(response)
                        }),
                        error: (error) => {
                            console.log(error)
                        }
                    })
                })
            });

            $.each(deletePage, function(index, value) {
                $(value).click(function (event) {
                    const idPage = $(this).attr('data-id-page');
                    editor.runCommand('delete-page', {
                        id: parseInt(idPage),
                        success: (response => {
                            console.log(response)
                        }),
                        error: (error) => {
                            console.log(error)
                        }
                    })
                })
            });

            $.each(editNamePage, function(index, value) {
                $(value).click(function (event) {
                    const idPage = $(this).attr('data-id-page');
                    $('.inputNamaPage'+idPage).removeAttr('readonly').focus();

                    $('.inputNamaPage'+idPage).blur(function(event) {
                        editor.runCommand('edit-name-page', {
                            id: parseInt(idPage),
                            title: $(this).val(),
                            success: (response => {
                                console.log(response)
                            }),
                            error: (error) => {
                                console.log(error)
                            }
                        })
                    })
                })
            });
        }

        editor.DomComponents.addType('menu-link', {
            isComponent: el => el.tagName === 'A' && el.classList.contains('menu-link'),
            model: {
              defaults: {
                traits: [],
              },
              init() {
                this.on('change:attributes:href', this.handleLinkChange);
              },
              handleLinkChange() {
                const href = this.get('attributes').href;
              },
            },
          });


        // Tambahkan Tailwind CSS ke iframe editor
        editor.on('load', () => {
            const frame = editor.Canvas.getFrameEl();
            const head = frame.contentDocument.head;

            // Tambahkan Tailwind CSS
            const tailwindLink = document.createElement('link');
            tailwindLink.rel = 'stylesheet';
            tailwindLink.href = options.tailwindCss;
            head.appendChild(tailwindLink);

            // Tambahkan Prism CSS
            const prismLink = document.createElement('link');
            prismLink.rel = 'stylesheet';
            prismLink.href = options.prismCss;
            head.appendChild(prismLink);

            // Tambahkan Prism JS
            const prismScript = document.createElement('script');
            prismScript.src = options.prismJs;
            head.appendChild(prismScript);

            // Tambahkan Prism JS
            const flowBetJs = document.createElement('script');
            flowBetJs.src = options.flowbetJs;
            head.appendChild(flowBetJs);

            // Tambahkan Prism CSS
            const flowbetCss = document.createElement('link');
            flowbetCss.rel = 'stylesheet';
            flowbetCss.href = options.flowbetCss;
            head.appendChild(flowbetCss);
        });

        editor.Panels.addButton('options', [{
            id: 'save-button',
            className: 'btn-save',
            label: '<i class="ri-save-line"></i>',
            visible: true,
            active: false,
            context: 'save',
            attributes: {title : 'Simpan Project'}
        }]);

        editor.Panels.addButton('options', [{
            id: 'export-project',
            className: 'btn-export',
            label: '<i class="ri-folder-zip-line"></i>',
            command: 'export-project',
            context: 'export',
            visible: false,
            active: false,
            attributes: {title : 'Export Project'}
        }]);

        // Panggil Prism untuk syntax highlighting setelah komponen baru ditambahkan
        editor.on('component:add', () => {
            const frame = editor.Canvas.getFrameEl();
            const doc = frame.contentDocument;
            if (doc && doc.defaultView && doc.defaultView.Prism) {
                doc.defaultView.Prism.highlightAll();
            }
        });

        // Panggil Prism untuk syntax highlighting setelah komponen dipilih
        editor.on('component:selected', () => {
            const frame = editor.Canvas.getFrameEl();
            const doc = frame.contentDocument;
            if (doc && doc.defaultView && doc.defaultView.Prism) {
                doc.defaultView.Prism.highlightAll();
            }
        });

        // Tambahkan perintah untuk mendapatkan blok dari API berdasarkan ID tema
        editor.Commands.add('get-blocks', {
            run(editor) {
                if (options.idTheme) {
                    fetchBlocks(options.idTheme);
                } else {
                    console.error('ID tema tidak disediakan.');
                }
            }
        });

        editor.Commands.add('save-project', {
            run(editor, sender, {success, error}) {
                const projects = editor.Pages.getAll();
                const arrayPages = [];
                projects.map(page => {
                    if(page.attributes.name !== '') {
                        const component = page.getMainComponent();
                        const idPage = page.id;
                        const html = editor.getHtml({component});
                        const css = editor.getCss({component});
                        console.log(css)

                        const object = {
                            id: idPage,
                            content: html,
                            style: css
                        };

                        arrayPages.push(object);
                    }
                });

                if(arrayPages.length > 0) {
                    saveProject({
                        _token: options.csrfToken,
                        pages: arrayPages
                    }).then(response => {
                        success(response);
                    }).catch(err => {
                        error(err);
                    })
                }
            }
        })

        editor.Commands.add('copy-page', {
            run(editor, sender, {id, success, error}) {
                const currentPage = editor.Pages.get(id);
                const component = currentPage.getMainComponent();
                const html = editor.getHtml({component});
                const css = editor.getCss({component});
                console.log(css)
                const name = currentPage.getName();
                storePage({
                    title: `${name} Copy`,
                    content: html,
                    style: css,
                    _token: options.csrfToken
                }).then(response => {
                    editor.runCommand('get-pages');
                    success(response);
                }).catch(err => {
                    error(err)
                })
            }
        });

        editor.Commands.add('delete-page', {
            run(editor, sender, {id, success, error}) {
                destroyPage({
                    id: id,
                    _token: options.csrfToken
                })
                .then(response => {
                    editor.runCommand('get-pages');
                    success(response);
                }).catch(err => {
                    error(err);
                })
            }
        });

        editor.Commands.add('edit-name-page', {
            run(editor, sender, {id, title, success, error}) {
                updateNamePage({
                    id: id,
                    title: title,
                    _token: options.csrfToken
                })
                .then(response => {
                    editor.runCommand('get-pages');
                    success(response);
                }).catch(err => {
                    error(err);
                })
            }
        });

        editor.Commands.add('get-pages', {
            run(editor) {
                if (options.apiUrlPages) {
                    fetchPages(options.apiUrlPages);
                } else {
                    console.error('ID tema tidak disediakan.');
                }
            }
        });

        editor.Commands.add('add-page', {
            run(editor, sender, value) {
                const pages = editor.Pages;
                console.log(pages)
            }
        });

        fetchBlocks();
        fetchPages();

        $.storePage = storePage;
    }

    if (typeof grapesjs !== 'undefined') {
        grapesjs.plugins.add('grapesjs-tailwind', pluginGrapes);
    } else {
        window.grapesjsTailwind = pluginGrapes;
    }
})()
