import React from "react"
import Image from "next/image"

export const config = {
	id: "custom_dynamic_fields:Section-Insights",
}

// Helper to get image URL from included data
const getImageUrl = (imageId, included) => {
	const media = included.find(
		(item) => item.type === "media--image" && item.id === imageId
	)
	if (!media) return null
	const fileRel = media.relationships?.thumbnail?.data
	if (!fileRel) return null
	const file = included.find(
		(item) => item.type === "file--image" && item.id === fileRel.id
	)
	return file?.attributes?.uri?.value?._default || file?.attributes?.uri?.url || null
}

// Helper to get taxonomy label for a node using drupal_internal__target_id from field_image_cover_news
const getTaxonomyLabel = (item, taxonomies) => {
	const imageRel = item.relationships?.field_image_cover_news?.data
	const targetId = imageRel?.meta?.drupal_internal__target_id
	if (!targetId) return null
	const newsCategory = taxonomies?.news_category || []
	const found = newsCategory.find((cat) => String(cat.id) === String(targetId))
	return found ? found.label : null
}

const SectionInsightsWidget = ({ data }) => {
	const collection = data?.components?.[0]?.collection?.data || {}
	const insights = collection?.data || []
	const included = collection?.included || []
	const taxonomies = collection?.taxonomies || {}

	return (
		<section style={{ padding: "40px 0", background: "#fff" }}>
			<style>{`
                .vf-insight-card {
                    transition: transform 0.3s cubic-bezier(.4,0,.2,1), box-shadow 0.3s cubic-bezier(.4,0,.2,1);
                    border-radius: 24px;
                    box-shadow: 0 4px 24px #0001;
                }
                .vf-insight-card:hover {
                    transform: scale(1.04);
                    box-shadow: 0 8px 32px #0002;
                    z-index: 2;
                }
                .vf-insight-title {
                    transition: color 0.2s;
                    color: #111;
                    text-decoration: none;
                }
                .vf-insight-card:hover .vf-insight-title {
                    color: #1877f2;
                    text-decoration: underline;
                }
                .vf-taxonomy-chip {
                    display: inline-block;
                    background: #1877f2;
                    color: #fff;
                    font-weight: 700;
                    font-size: 15px;
                    border-radius: 10px;
                    padding: 6px 18px;
                    letter-spacing: 1px;
                    margin-bottom: 18px;
                    margin-top: 8px;
                    text-transform: uppercase;
                }
            `}</style>
			<div style={{ maxWidth: 1240, margin: "0 auto" }}>
				<h2
					style={{
						fontWeight: 700,
						fontSize: 48,
						marginBottom: 8,
						letterSpacing: "-2px",
					}}
				>
					INSIGHTS
				</h2>
				<p style={{ color: "#555", marginBottom: 36, fontSize: 22, textAlign: "center" }}>
					Découvrez nos actualités, nos analyses et les points de vue de nos experts
				</p>
				<div
					style={{
						display: "flex",
						gap: 32,
						marginBottom: 48,
						flexWrap: "wrap",
						justifyContent: "center",
					}}
				>
					{insights.map((item) => {
						const { attributes, relationships } = item
						const imageId = relationships?.field_image_cover_news?.data?.id
						const imageUrl = getImageUrl(imageId, included)
						const taxonomyLabel = getTaxonomyLabel(item, taxonomies)

						return (
							<div
								key={item.id}
								className="vf-insight-card"
								style={{
									background: "#fff",
									borderRadius: 24,
									boxShadow: "0 4px 24px #0001",
									width: 380,
									minHeight: 480,
									display: "flex",
									flexDirection: "column",
									overflow: "hidden",
									cursor: "pointer",
								}}
							>
								<div
									style={{
										width: "100%",
										height: 220,
										background: "#eee",
										position: "relative",
									}}
								>
									{imageUrl ? (
										<Image
											src={imageUrl}
											alt={attributes.title}
											fill
											style={{
												objectFit: "cover",
												display: "block",
											}}
											sizes="380px"
										/>
									) : (
										<div
											style={{
												width: "100%",
												height: "100%",
												display: "flex",
												alignItems: "center",
												justifyContent: "center",
												color: "#aaa",
												fontSize: 32,
												background: "#ddd",
											}}
										>
											1200 x 630
										</div>
									)}
								</div>
								<div
									style={{
										padding: 32,
										flex: 1,
										display: "flex",
										flexDirection: "column",
									}}
								>
									{taxonomyLabel && (
										<div className="vf-taxonomy-chip">{taxonomyLabel}</div>
									)}
									<a
										href={attributes.path?.alias || "#"}
										className="vf-insight-title"
										style={{
											fontWeight: 700,
											fontSize: 26,
											margin: 0,
											marginBottom: 18,
											textDecoration: "none",
											lineHeight: 1.2,
											display: "inline-block",
										}}
									>
										{attributes.title}
									</a>
									<div style={{ flex: 1 }} />
									<a
										href={attributes.path?.alias || "#"}
										style={{
											color: "#1877f2",
											fontWeight: 700,
											textDecoration: "underline",
											fontSize: 18,
											marginTop: "auto",
											letterSpacing: "0.5px",
										}}
									>
										LIRE PLUS
									</a>
								</div>
							</div>
						)
					})}
				</div>
				<div style={{ textAlign: "center" }}>
					<button
						style={{
							border: "2px solid #1877f2",
							color: "#1877f2",
							background: "#fff",
							borderRadius: 12,
							padding: "18px 48px",
							fontWeight: 700,
							fontSize: 20,
							cursor: "pointer",
							transition: "background 0.2s, color 0.2s",
						}}
						onClick={() => {
							window.location.href = "/insights"
						}}
					>
						VOIR PLUS D'ACTUALITÉS
					</button>
				</div>
			</div>
		</section>
	)
}

export default SectionInsightsWidget
