import Image from "next/image"
import { Link } from "@/ui"

export const config = {
	id: "custom_dynamic_fields:Know-More-DF",
}

const KnowMoreWidget = ({ data }) => {
	if (!data || !data.components || !data.components.length) {
		return null
	}

	// Get the first component from the array
	const component = data.components[0]

	// Destructure properties from the component
	const {
		title,
		description,
		image,
		link: { title: cta_label, url: cta_url } = {},
		background_color = "#0078FF", // Default blue if not provided
	} = component

	return (
		<div
			className="relative w-full overflow-hidden"
			style={{ backgroundColor: background_color }}
		>
			<div className="w-full px-4 py-12 md:py-16">
				<div className="mx-auto max-w-7xl">
					<div className="flex flex-col items-center md:flex-row md:items-center md:justify-between">
						{/* Image section - left side on desktop, top on mobile */}
						<div className="mb-8 md:mb-0 md:w-5/12 lg:w-1/2">
							<div className="relative mx-auto max-w-sm md:mx-0 md:max-w-none">
								{image && image[0] && (
									<Image
										src={image[0]._default}
										alt={image[0]?.meta?.alt || "Fintech services card"}
										width={500}
										height={330}
										className="transform transition duration-500 hover:scale-105"
										priority
									/>
								)}
							</div>
						</div>

						{/* Content section - right side on desktop, bottom on mobile */}
						<div className="text-center md:w-7/12 md:pl-10 md:text-left lg:w-1/2 lg:pl-16">
							{/* Title with horizontal line aligned */}
							<div className="flex items-center justify-center md:justify-start">
								<div className="mr-4 h-0.5 w-8 bg-white"></div>
								<h2 className="text-lg font-bold text-white md:text-xl lg:text-2xl">
									{title || "LES FINTECHS AU SERVICE DE LA CROISSANCE EN AFRIQUE"}
								</h2>
							</div>

							<div className="mt-6 text-white">
								<p className="text-sm md:text-base">
									{description ||
										"La raison d'être de Capital Azur : Favoriser financière en Afrique afin d'accompagner le continent dans sa croissance et l'inclusion financière. C'est pour cela que nous nous reposons sur le State Of The Art de la technologie. Fintechs, Blockchain, Mobile Banking, Digital Banking.. sont autant de moyens que nous mettons en oeuvre pour répondre à vos besoins, qui que vous soyez, où que vous voyez.."}
								</p>

								{cta_label && (
									<div className="mt-8">
										<Link
											href={cta_url || "#"}
											className="text-blue hover:bg-blue inline-block rounded-full border-2 bg-transparent px-10 py-4 text-center font-medium uppercase transition hover:text-white"
										>
											{cta_label || "EN SAVOIR PLUS"}
										</Link>
									</div>
								)}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	)
}

export default KnowMoreWidget
