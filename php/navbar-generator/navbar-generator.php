<?php 
class NavbarGenerator
{
    private $navbarData;

    public function __construct($navbarData)
    {
        $this->navbarData = $navbarData;
    }

    public function generate()
    {
        $navbar = '<nav class="' . $this->navbarData['css_class'] . '"';
        if (isset($this->navbarData['id'])) {
            $navbar .= ' id="' . $this->navbarData['id'] . '"';
        }
        if (isset($this->navbarData['style'])) {
            $navbar .= ' style="' . $this->navbarData['style'] . '"';
        }
        $navbar .= '>';

        if (isset($this->navbarData['brand'])) {
            $navbar .= '<a class="navbar-brand" href="' . $this->navbarData['brand']['href'] . '">';
            if (isset($this->navbarData['brand']['logo'])) {
                $navbar .= '<img src="' . $this->navbarData['brand']['logo'] . '" alt="' . $this->navbarData['brand']['text'] . '">';
            }
            $navbar .= $this->navbarData['brand']['text'] . '</a>';
        }

        if (isset($this->navbarData['links'])) {
            $navbar .= '<ul class="navbar-nav">';
            foreach ($this->navbarData['links'] as $link) {
                $navbar .= '<li class="nav-item"><a class="nav-link" href="' . $link['link'] . '">' . $link['text'] . '</a></li>';
            }
            $navbar .= '</ul>';
        }
        if (isset($this->navbarData['search'])) {
            $navbar .= '<form class="d-flex" role="search">';
            foreach ($this->navbarData['search'] as $search) {
                $placeholder = isset($search['placeholder']) ? $search['placeholder'] : 'Search';
                $title = isset($search['title']) ? $search['title'] : 'Search';
                $input_class = isset($search['input_class']) ? $search['input_class'] : 'form-control me-2';
                $btn_class = isset($search['btn_class']) ? $search['btn_class'] : 'btn btn-outline-success';
                $navbar .= '<input class="' . $input_class . '" type="search" placeholder="' . $placeholder . '" aria-label="Search"><button class="' . $btn_class . '" type="submit">' . $title . '</button>';
            }
            $navbar .= '</form>';
        }

        $navbar .= '</nav>';

        return $navbar;
    }
}
