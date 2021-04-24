<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Author;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;


/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ORM\Table(name="books",uniqueConstraints={@ORM\UniqueConstraint(name="unique_isbn", columns={"isbn"})})
 * @Vich\Uploadable
 * @UniqueEntity("Isbn")
 */
class Book
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Positive
     */
    private $Isbn;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Img_url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $topcis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     * @Assert\NotBlank
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     * @Assert\NotBlank
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="book")
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255)
     * Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $file_url;


    /**
     * simple property to upload file
     * 
     * @Vich\UploadableField(mapping="books_files", fileNameProperty="file_url")
     * 
     * @Assert\File(
     *     maxSize = "10M",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF "
     * )
     * 
     * @var File|null
     */
    private $bookFile;

    /**
     * * simple property to upload image
     * * @Vich\UploadableField(mapping="books_images", fileNameProperty="Img_url")
     *   @Assert\Image(
     *     maxSize = "10M",
     *     mimeTypes = {"image/jpg", "image/jpeg","image/png"},
     *     mimeTypesMessage = "Please upload a valid Format"
     * 
     * )
     */
    private $bookImage;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

  



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->Isbn;
    }

    public function setIsbn(string $Isbn): self
    {
        $this->Isbn = $Isbn;

        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->Img_url;
    }

    public function setImgUrl(?string $Img_url): self
    {
        $this->Img_url = $Img_url;

        return $this;
    }

    public function getFileUrl()
    {
        return $this->file_url;
    }   

    public function setFileUrl(?string $file_url): self
    {
        $this->file_url = $file_url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getTopcis(): ?string
    {
        return $this->topcis;
    }

    public function setTopcis(?string $topcis): self
    {
        $this->topcis = $topcis;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setBook($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

 

     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $bookFile
     */
    public function setBookFile(?File $bookFile = null): void
    {
        $this->bookFile = $bookFile;
     
        if (null !== $bookFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getBookFile(): ?File
    {
        return $this->bookFile;
    }

    public function setBookImage(?File $bookImage= null): void
    {
        $this->bookImage = $bookImage;

        if (null !== $bookImage) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getBookImage(): ?File
    {
        return $this->bookImage;
    }

     /**
     * @var DateTime $created
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var DateTime $updated
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $dateTimeNow = new DateTime('now');

        $this->setUpdatedAt($dateTimeNow);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }
    }

    public function getCreatedAt() :?DateTime
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt() :?DateTime
    {
        return $this->updatedAt;
    }
    
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    
}
