<?php


namespace JohnnyHuy\Laravel\Inline\Renderer;


interface GetContentInterface
{
    /**
     * Get content for a renderer.
     * This is useful for doing get requests to APIS.
     *
     * @param string $url
     * @return string
     */
    public function getContent(string $url): string;
}