import { DrupalNode } from "next-drupal"
import { drupal } from "@/lib/drupal"
import { ArticleTeaser } from "@/components/drupal/ArticleTeaser"
import Footer from "@/components/footer"

export const metadata = {
  title: "Articles",
}

async function getArticles(): Promise<DrupalNode[]> {
  return await drupal.getResourceCollection<DrupalNode[]>("node--article")
}

export default async function ArticlesPage() {
  const articles = await getArticles()

  return (
    <div>
      <div>
        <h1>Articles</h1>
        {articles?.length > 0 ? (
          articles.map((article) => (
            <ArticleTeaser key={article.id} node={article} />
          ))
        ) : (
          <p>No articles found</p>
        )}
      </div>
      <div>
        <h1 className="mt-4 text-blue-500/75 text-3xl underline underline-offset-1">
          {" "}
          This is a footer from Boostrap
        </h1>
        {/* use the footer */}
        <Footer /> {/* Add the Footer component here */}
      </div>
    </div>
  )
}
