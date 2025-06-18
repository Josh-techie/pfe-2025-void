import { Link } from "@/ui"
import Image from "next/image"

export const config = {
	id: "custom_dynamic_fields:Presence-DF",
}

export const SectionPresenceWidget = ({ data }) => {
	// Extract data from the first component
	const component = data?.components?.[0] || {}
	const title = component.title || "ACCÉDEZ À NOS SERVICES, OÙ QUE VOUS SOYEZ."
	const description =
		component.description ||
		"Nos services sont accessibles au niveau de 13 pays en Afrique, et bien plus dans les prochains mois !"
	const linkData = component.link || {
		title: "NOTRE PRÉSENCE EN AFRIQUE",
		url: "/trouver-une-agence",
	}
	const mapImage = component.image?.[0]?._default || ""
	const mapImageAlt = component.image?.[0]?.meta?.alt || "Carte de présence en Afrique"

	return (
		<section
			className="bg-[#F4F8F8] py-16 lg:py-24"
			style={{ fontFamily: "Montserrat, sans-serif" }}
		>
			<div className="mx-auto max-w-7xl px-6 lg:px-8">
				<div className="flex flex-col items-start gap-12 lg:flex-row lg:items-center">
					{/* Left content: Text and CTA */}
					<div className="w-full lg:w-1/2">
						{/* Title with blue line */}
						<div className="mb-6 flex items-center">
							<div className="mr-6 mt-3 h-0.5 w-12 self-start bg-[#027CFF]"></div>
							<h2 className="text-xl font-bold text-gray-900 lg:text-2xl">{title}</h2>
						</div>

						{/* Description */}
						<p className="mb-10 ml-[4.5rem] text-lg text-gray-600">{description}</p>

						{/* CTA Button */}
						<div className="ml-[4.5rem]">
							<Link
								href={linkData.url || "#"}
								className="inline-block rounded-md bg-white px-8 py-4 text-sm font-bold text-blue-500 shadow-md transition-all hover:bg-blue-500 hover:text-white"
							>
								{linkData.title}
							</Link>
						</div>
					</div>

					{/* Right content: Map Image */}
					<div className="relative w-full lg:w-1/2">
						{mapImage && (
							<Image
								src={mapImage}
								alt={mapImageAlt}
								width={845}
								height={480}
								className="rounded-lg"
								style={{
									maxWidth: "100%",
									height: "auto",
								}}
							/>
						)}

						{/* Example location marker - you can add more based on real data */}
						<div className="absolute right-1/3 top-1/2 flex flex-col items-center">
							<div className="relative">
								<div className="absolute h-6 w-6 animate-ping rounded-full bg-blue-100 opacity-75"></div>
								<div className="relative h-4 w-4 rounded-full bg-blue-500"></div>
							</div>
							<div className="mt-2 rounded-lg bg-white p-2 text-xs font-medium shadow-md">
								Casablanca, 20000
								<br />
								Maroc
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	)
}

export default SectionPresenceWidget
