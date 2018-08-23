<?php

namespace Fire\Model\AbstractPost;

use Fire\Model\Entity;
use Fire\Contracts\Model\AbstractPost\AbstractPost as AbstractPostContract;

abstract class AbstractPost extends Entity implements AbstractPostContract
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $authorId;

    /**
     * @var Fire\Contracts\Model\Identity\User
     */
    protected $author;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $excerpt;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $commentStatus;

    /**
     * @var string
     */
    protected $pingStatus;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $modified;

    /**
     * @var integer
     */
    protected $parentId;

    /**
     * @var Fire\Contracts\Model\AbstractPost\AbstractPost
     */
    protected $parent;

    /**
     * @var integer
     */
    protected $menuOrder;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var Fire\Contracts\Model\Upload\Upload
     */
    protected $featuredImage;

    /**
     * @var Fire\Foundation\Collection
     */
    protected $comments;

    /**
     * @var array
     */
    protected $native;

    /**
     * Create a new post
     *
     * @param $data array
     * @return void
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $prop => $value) {
            $method = 'set'.ucfirst($prop);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function id()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function authorId()
    {
        return $this->authorId;
    }

    public function setAuthorId($id)
    {
        $this->authorId = $id;
    }

    public function author()
    {
        return $this->lazyLoad($this->author);
    }

    public function setAuthor($user)
    {
        $this->author = $user;
    }

    /**
     * Get the formatted date
     *
     * @param string $format http://php.net/date
     * @return string
     */
    public function date($format = 'F j, Y')
    {
        return date($format, strtotime($this->date));
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * {@inheritdoc}
     * @filter the_content
     */
    public function content()
    {
        if ($native = $this->getNative()) {
            // This is why I hate WordPress
            setup_postdata((object) $native);
            $GLOBALS['post'] = (object) $native;
            the_post();
            ob_start();
            the_content();
            $content = ob_get_clean();
            wp_reset_postdata();
        } else {
            $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', $this->content));;
        }

        return $content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * {@inheritdoc}
     * @filter the_title
     */
    public function title()
    {
        return apply_filters('the_title', $this->title, $this->id());
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the excerpt
     *
     * @deprecated 2.2.0 use `summary` method instead
     * @filter the_excerpt
     * @filter get_the_excerpt
     * @filter fire/model/post/excerpt
     * @param integer $limit Number of words/characters to limit to
     * @param string $append String to append to trimmed excerpt
     * @param boolean $words Whether to limit to words (true) or characters (false)
     * @param boolean $preserveWords Limit to character number, but preserve full words
     * @param boolean $force Use excerpt without stripping tags
     */
    public function excerpt($limit = null, $append = null, $words = true, $preserveWords = null, $force = false)
    {
        if ($this->excerpt && ! $force) {
            $excerpt = $this->excerpt;
        } else {
            $excerpt = $this->excerpt ? $this->excerpt : $this->content;
            $excerpt = apply_filters('the_excerpt', apply_filters('get_the_excerpt', $excerpt));
            $excerpt = strip_tags(wp_kses_no_null(trim(strip_shortcodes($excerpt))));
        }

        if ($limit && strlen($excerpt) > $limit) {
            $excerpt = $words
                     ? limitWords($excerpt, $limit, $append)
                     : limitChars($excerpt, $limit, $append, $preserveWords);
        }

        return apply_filters('fire/model/post/excerpt', $excerpt, $this);
    }

    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
    }

    /**
     * Get the summary/excerpt
     *
     * This method replaces the now deprecated `excerpt` method and handles excerpts
     * the way WordPress normally does, allowing the <!--more--> tag and the
     * custom excerpt field to be used.
     *
     * @param integer $limit Number of words to limit
     * @param string $append String to append to trimmed excerpt
     * @return string
     */
    public function summary($limit = null, $append = null)
    {
        $limitFilter = function () use ($limit) { return (int) $limit; };
        $appendFilter = function () use ($append) { return $append; };

        if ($limit) {
            add_filter('excerpt_length', $limitFilter);
        }

        if ($append) {
            add_filter('excerpt_more', $appendFilter);
        }

        setup_postdata((object) $this->getNative());
        $GLOBALS['post'] = (object) $this->getNative();
        the_post();
        ob_start();
        the_excerpt();
        $excerpt = ob_get_clean();
        wp_reset_postdata();

        remove_filter('excerpt_length', $limitFilter);
        remove_filter('excerpt_more', $appendFilter);

        return $excerpt;
    }

    public function status()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get the comment status
     *
     * @return string
     */
    public function commentStatus()
    {
        return $this->commentStatus;
    }

    /**
     * Set the comment status
     *
     * @param string $status
     * @return void
     */
    public function setCommentStatus($status)
    {
        $this->commentStatus = $status;
    }

    /**
     * Get the ping status
     *
     * @return string
     */
    public function pingStatus()
    {
        return $this->pingStatus;
    }

    /**
     * Set the ping status
     *
     * @param string $status
     * @return void
     */
    public function setPingStatus($status)
    {
        $this->pingStatus = $status;
    }

    public function password()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function slug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get the modified date
     *
     * @param string $format http://php.net/date
     * @return string
     */
    public function modified($format = 'F j, Y')
    {
        return date($format, strtotime($this->modified));
    }

    /**
     * Set the modified date
     *
     * @param string $date
     * @return void
     */
    public function setModified($date)
    {
        $this->modified = $date;
    }

    public function parentId()
    {
        return $this->parentId;
    }

    public function setParentId($id)
    {
        $this->parentId = $id;
    }

    public function parent()
    {
        return $this->lazyLoad($this->parent);
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Check if post has any children
     *
     * @return boolean
     */
    public function hasChildren()
    {
        global $wpdb;
        return (bool) $wpdb->get_var($wpdb->prepare("
            select count(*)
            from $wpdb->posts
            where post_type = '%s'
            and post_status = 'publish'
            and post_parent = %d
            limit 1
        ", $this->type(), $this->id()));
    }

    /**
     * Get the menu order
     *
     * @return string
     */
    public function menuOrder()
    {
        return $this->menuOrder;
    }

    /**
     * Set the menu order
     *
     * @param string $order
     * @return void
     */
    public function setMenuOrder($order)
    {
        $this->menuOrder = $order;
    }

    public function type()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get the featured image
     *
     * @return Fire\Contracts\Model\Upload\Upload
     */
    public function featuredImage()
    {
        return $this->lazyLoad($this->featuredImage);
    }

    /**
     * Set the featured image
     *
     * @param Fire\Contracts\Model\Upload\Upload|Closure $image
     */
    public function setFeaturedImage($image)
    {
        $this->featuredImage = $image;
    }

    /**
     * Check if a featured image is set
     *
     * @return boolean
     */
    public function hasFeaturedImage()
    {
        return has_post_thumbnail($this->id());
    }

    /**
     * Get the post comments
     *
     * @return Fire\Foundation\Collection
     */
    public function comments()
    {
        return $this->lazyLoad($this->comments);
    }

    /**
     * Set the post comments
     *
     * @param Fire\Foundation\Collection|Closure $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * Get the comment count
     *
     * @return integer
     */
    public function commentCount()
    {
        return wp_count_comments($this->id());
    }

    /**
     * Get the URL
     *
     * @return string
     */
    public function url()
    {
        return get_permalink($this->id());
    }

    /**
     * Get the edit URL
     *
     * @return string
     */
    public function editUrl()
    {
        return get_edit_post_link($this->id());
    }

    /**
     * Get a list of terms for a taxonomy this post belongs to
     *
     * @param string $taxonomy
     * @param string $sep List separator, commonly ", "
     * @return string
     */
    public function termList($taxonomy = 'category', $sep = null)
    {
        return get_the_term_list($this->id(), $taxonomy, null, $sep, null);
    }

    /**
     * Check if post belongs to term(s)
     *
     * @param string $taxonomy
     * @param mixed $terms Single term or array of term names, ids, or slugs
     * @return boolean
     */
    public function hasTerms($taxonomy = 'category', $terms = null)
    {
        return has_term($terms, $taxonomy, $this->id());
    }

    /**
     * Check if comments are enabled
     *
     * @return boolean
     */
    public function isCommentable()
    {
        return comments_open($this->id());
    }

    /**
     * Check if pings are enabled
     *
     * @return boolean
     */
    public function isPingable()
    {
        return pings_open($this->id());
    }

    /**
     * Get a string of HTML classes
     *
     * @param string $extra Extra class names to add
     * @return string
     */
    public function htmlClasses($extra = null)
    {
        return implode(' ', get_post_class($extra, $this->id()));
    }

    /**
     * Get the original post array returned by WordPress
     *
     * @return array
     */
    public function getNative()
    {
        return $this->native;
    }

    /**
     * Set the original post array returned by WordPress
     *
     * @param array $post
     */
    public function setNative(array $post)
    {
        $this->native = $post;
    }
}
