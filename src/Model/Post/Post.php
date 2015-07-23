<?php

namespace Fire\Model\Post;

use Fire\Model\Entity;
use Fire\Contracts\Model\Post\Post as PostContract;

class Post extends Entity implements PostContract {

	/**
	 * @Column(name='ID')
	 */
	protected $id;

	/**
	 * @Column(name='post_author')
	 * @var  Fire\Contracts\Model\Identity\User
	 */
	protected $author;

	/**
	 * @Column(name='post_date')
	 */
	protected $date;

	/**
	 * @Column(name='post_content')
	 */
	protected $content;

	/**
	 * @Column(name='post_title')
	 */
	protected $title;

	/**
	 * @Column(name='post_excerpt')
	 */
	protected $excerpt;

	/**
	 * @Column(name='post_status')
	 */
	protected $status;

	/**
	 * @Column(name='comment_status')
	 */
	protected $commentStatus;

	/**
	 * @Column(name='ping_status')
	 */
	protected $pingStatus;

	/**
	 * @Column(name='post_password')
	 */
	protected $password;

	/**
	 * @Column(name='post_name')
	 */
	protected $slug;

	/**
	 * @Column(name='post_modified')
	 */
	protected $modified;

	/**
	 * @Column(name='post_parent')
	 * @var  Fire\Contracts\Model\Post\Post
	 */
	protected $parent;

	/**
	 * @Column(name='menu_order')
	 */
	protected $menuOrder;

	/**
	 * @Column(name='post_type')
	 */
	protected $type;

	/**
	 * @var  array
	 */
	protected $native;

	/**
	 * Create a new post
	 *
	 * @param   $data  array
	 * @return  void
	 */
	public function __construct(array $data = [])
	{
		foreach ($data as $prop => $value)
		{
			$method = 'set'.ucfirst($prop);

			if (method_exists($this, $method))
			{
				$this->$method($value);
			}
		}
	}

	/**
	 * Return the ID
	 *
	 * @return  integer
	 */
	public function id()
	{
		return $this->id;
	}

	/**
	 * Set the ID
	 * 
	 * @param   $id  string|integer
	 * @return  void
	 */
	public function setId($id)
	{
		$this->id = (int) $id;
	}

	/**
	 * Get the author
	 * 
	 * @return  Fire\Contracts\Model\Identity\User
	 */
	public function author()
	{
		return $this->lazyLoad($this->author);
	}

	/**
	 * Set the author
	 * 
	 * @param   $user  Fire\Contracts\Model\Identity\User|Closure
	 * @return  void
	 */
	public function setAuthor($user)
	{
		$this->author = $user;
	}

	/**
	 * Get the formatted date
	 * 
	 * @param   $format  string  http://php.net/date
	 * @return  string
	 */
	public function date($format = 'F j, Y')
	{
		return date($format, strtotime($this->date));
	}

	/**
	 * Set the date
	 * 
	 * @param   $date  string
	 * @return  void
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}

	/**
	 * Get the content
	 *
	 * @filter  the_content
	 * @return  string
	 */
	public function content()
	{
		if ($native = $this->getNative())
		{
			// This is why I hate WordPress
			setup_postdata($native);

			$content = get_the_content();

			wp_reset_postdata();
		}
		else
		{
			$content = $this->content;
		}

		return str_replace(']]>', ']]&gt;', apply_filters('the_content', $content));
	}

	/**
	 * Set the content
	 * 
	 * @param   $content  string
	 * @return  void
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * Get the title
	 *
	 * @filter  the_title
	 * @return  string
	 */
	public function title()
	{
		return apply_filters('the_title', $this->title, $this->id());
	}

	/**
	 * Set the title
	 * 
	 * @param   $title  string
	 * @return  void
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * Get the excerpt
	 *
	 * @filter  the_excerpt
	 * @filter  get_the_excerpt
	 * @filter  fire/model/post/excerpt
	 * @param   $limit          int      Number of words/characters to limit to
	 * @param   $append         string   String to append to trimmed excerpt
	 * @param   $words          boolean  Whether to limit to words (true) or characters (false)
	 * @param   $preserveWords  boolean  Limit to character number, but preserve full words
	 * @param   $force          boolean  Use excerpt without stripping tags
	 * @return  string
	 */
	public function excerpt($limit = null, $append = null, $words = true, $preserveWords = null, $force = false)
	{
		if ($this->excerpt and ! $force)
		{
			$excerpt = $this->excerpt;
		}
		else
		{
			$excerpt = $this->excerpt ? $this->excerpt : $this->content();
			$excerpt = apply_filters('the_excerpt', apply_filters('get_the_excerpt', $excerpt));
			$excerpt = strip_tags(wp_kses_no_null(trim(strip_shortcodes($excerpt))));
		}

		if ($limit and strlen($excerpt) > $limit)
		{
			$excerpt = $words ? limit_words($excerpt, $limit, $append)
			                  : limit_chars($excerpt, $limit, $append, $preserveWords);
		}

		return apply_filters('fire/model/post/excerpt', $excerpt, $this);
	}

	/**
	 * Set the excerpt
	 * 
	 * @param   $excerpt  string
	 * @return  void
	 */
	public function setExcerpt($excerpt)
	{
		$this->excerpt = $excerpt;
	}

	/**
	 * Get the status
	 * 
	 * @return  string
	 */
	public function status()
	{
		return $this->status;
	}

	/**
	 * Set the status
	 * 
	 * @param   $status  string
	 * @return  void
	 */
	public function setStatus($status)
	{
		$this->status = $status;
	}

	/**
	 * Get the comment status
	 * 
	 * @return  string
	 */
	public function commentStatus()
	{
		return $this->commentStatus;
	}

	/**
	 * Set the comment status
	 * 
	 * @param   $status  string
	 * @return  void
	 */
	public function setCommentStatus($status)
	{
		$this->commentStatus = $status;
	}

	/**
	 * Get the ping status
	 * 
	 * @return  string
	 */
	public function pingStatus()
	{
		return $this->pingStatus;
	}

	/**
	 * Set the ping status
	 * 
	 * @param   $status  string
	 * @return  void
	 */
	public function setPingStatus($status)
	{
		$this->pingStatus = $status;
	}

	/**
	 * Get the password
	 * 
	 * @return  string
	 */
	public function password()
	{
		return $this->password;
	}

	/**
	 * Set the password
	 * 
	 * @param   $password  string
	 * @return  void
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * Get the slug
	 * 
	 * @return  string
	 */
	public function slug()
	{
		return $this->slug;
	}

	/**
	 * Set the slug
	 * 
	 * @param   $slug  string
	 * @return  void
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;
	}

	/**
	 * Get the modified date
	 * 
	 * @param   $format  string  http://php.net/date
	 * @return  string
	 */
	public function modified($format = 'F j, Y')
	{
		return date($format, strtotime($this->modified));
	}

	/**
	 * Set the modified date
	 * 
	 * @param   $date  string
	 * @return  void
	 */
	public function setModified($date)
	{
		$this->modified = $date;
	}

	/**
	 * Get the parent post
	 *
	 * @return  Fire\Contracts\Model\Post\Post
	 */
	public function parent()
	{
		return $this->lazyLoad($this->parent);
	}

	/**
	 * Set the parent post
	 * 
	 * @param   $parent  Fire\Contracts\Model\Post\Post|Closure
	 * @return  void
	 */
	public function setParent($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * Get the menu order
	 * 
	 * @return  string
	 */
	public function menuOrder()
	{
		return $this->menuOrder;
	}

	/**
	 * Set the menu order
	 * 
	 * @param   $order  string
	 * @return  void
	 */
	public function setMenuOrder($order)
	{
		$this->menuOrder = $order;
	}

	/**
	 * Get the type
	 * 
	 * @return  string
	 */
	public function type()
	{
		return $this->type;
	}

	/**
	 * Set the type
	 * 
	 * @param   $type  string
	 * @return  void
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * Get the comment count
	 * 
	 * @return  integer
	 */
	public function commentCount()
	{
		return wp_count_comments($this->id());
	}

	/**
	 * Get the URL
	 * 
	 * @return  string
	 */
	public function url()
	{
		return get_permalink($this->id());
	}

	/**
	 * Get the edit URL
	 * 
	 * @return  string
	 */
	public function editUrl()
	{
		return get_edit_post_link($this->id());
	}

	/**
	 * Get a list of terms for a taxonomy this post belongs to
	 * 
	 * @param   $taxonomy  string
	 * @param   $sep       string  List separator, commonly ", "
	 * @return  string
	 */
	public function termList($taxonomy = 'category', $sep = null)
	{
		return get_the_term_list($this->id(), $taxonomy, null, $sep, null);
	}

	/**
	 * Check if post belongs to term(s)
	 * 
	 * @param   $taxonomy  string
	 * @param   $terms     string|integer|array  Single term or array of term names, ids, or slugs
	 * @return  boolean
	 */
	public function hasTerms($taxonomy = 'category', $terms = null)
	{
		return has_term($terms, $taxonomy, $this->id());
	}

	/**
	 * Check if comments are enabled
	 * 
	 * @return  boolean
	 */
	public function isCommentable()
	{
		return comments_open($this->id());
	}

	/**
	 * Check if pings are enabled
	 * 
	 * @return  boolean
	 */
	public function isPingable()
	{
		return pings_open($this->id());
	}

	/**
	 * Check if a featured image is set
	 * 
	 * @return  boolean
	 */
	public function hasFeaturedImage()
	{
		return has_post_thumbnail($this->id());
	}

	/**
	 * Get the featured image URL
	 * 
	 * @param   $size  string|array  String keyword or array for width and height
	 * @return  string
	 */
	public function featuredImageUrl($size = null)
	{
		$image = wp_get_attachment_image_src(get_post_thumbnail_id($this->id()), $size);

		return $image[0];
	}

	/**
	 * Get a string of HTML classes
	 * 
	 * @param   $extra  string  Extra class names to add
	 * @return  string
	 */
	public function htmlClasses($extra = null)
	{
		return implode(' ', get_post_class($extra, $this->id()));
	}

	/**
	 * Get the original post array returned by WordPress
	 * 
	 * @return  array
	 */
	public function getNative()
	{
		return $this->native;
	}

	/**
	 * Set the original post array returned by WordPress
	 * 
	 * @param  $post  array
	 */
	public function setNative(array $post)
	{
		$this->native = $post;
	}

}