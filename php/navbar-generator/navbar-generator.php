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
        $html = '<nav class="' . $this->navbarData['css_class'] . '"';
        if (isset($this->navbarData['id'])) {
            $html .= ' id="' . $this->navbarData['id'] . '"';
        }
        if (isset($this->navbarData['style'])) {
            $html .= ' style="' . $this->navbarData['style'] . '"';
        }
        $html .= '>';

        if (isset($this->navbarData['brand'])) {
            $html .= '<a class="navbar-brand" href="' . $this->navbarData['brand']['link'] . '">' . $this->navbarData['brand']['text'] . '</a>';
        }

        if (isset($this->navbarData['links'])) {
            $html .= '<ul class="navbar-nav">';
            foreach ($this->navbarData['links'] as $link) {
                $html .= '<li class="nav-item"><a class="nav-link" href="' . $link['link'] . '">' . $link['text'] . '</a></li>';
            }
            $html .= '</ul>';
        }
        if (isset($this->navbarData['search'])) {
            $html .= '<form class="d-flex" role="search">';
            foreach ($this->navbarData['search'] as $search) {
                $placeholder = isset($search['placeholder']) ? $search['placeholder'] : 'Search';
                $title = isset($search['title']) ? $search['title'] : 'Search';
                $input_class = isset($search['input_class']) ? $search['input_class'] : 'form-control me-2';
                $btn_class = isset($search['btn_class']) ? $search['btn_class'] : 'btn btn-outline-success';
                $html .= '<input class="' . $input_class . '" type="search" placeholder="' . $placeholder . '" aria-label="Search"><button class="' . $btn_class . '" type="submit">' . $title . '</button>';
            }
            $html .= '</form>';
        }

        $html .= '</nav>';

        return $html;
    }
}
