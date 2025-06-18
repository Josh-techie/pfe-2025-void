import Image from "next/image"

export const config = {
	id: "custom_dynamic_fields:Service-DF",
}

export const SectionServicesWidget = ({ data }) => {
	// Get the title and description from the first item
	const mainTitle =
		data?.components?.[0]?.title || "DES SERVICES INNOVANTS POUR UN QUOTIDIEN SIMPLIFIÉ"
	const mainDescription =
		data?.components?.[0]?.description ||
		"Capital Azur accompagne l'ensemble de sa clientèle dans leurs projets à toutes les étapes de leurs vie."

	// All services
	const services = data?.components || []

	return (
		<section
			className="bg-[#F4F8F8] pb-24 pt-10 lg:pb-32 lg:pt-16"
			style={{ fontFamily: "Montserrat, sans-serif" }}
		>
			<div className="mx-auto max-w-6xl px-6 lg:px-8">
				{/* Header Section */}
				{/* Title with inline blue line */}
				<div className="mb-6 flex items-center">
					<div className="mr-6 h-0.5 w-12 bg-[#027CFF]"></div>
					<h2 className="text-2xl font-bold text-gray-900 lg:text-3xl">{mainTitle}</h2>
				</div>
				<p className="mb-16 ml-[4.5rem] text-lg text-gray-600">{mainDescription}</p>
			</div>

			{/* Service Cards Grid */}
			<div className="mx-auto max-w-6xl px-6 lg:px-8">
				<div className="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
					{services.map((service, index) => (
						<div
							key={index}
							className="flex flex-col rounded-lg bg-white p-6 shadow-sm transition-all duration-500 hover:scale-[1.05] hover:shadow-[0_15px_30px_-10px_rgba(1,120,246,0.3)]"
						>
							{/* Image/Illustration */}
							<div className="mb-4 flex h-28 w-full items-center justify-center">
								{service.image && service.image[0] && (
									<Image
										src={service.image[0]._default}
										alt={service.image[0].meta.alt || service.subtitle || ""}
										width={120}
										height={80}
										style={{
											objectFit: "contain",
											maxWidth: "100%",
											height: "auto",
										}}
									/>
								)}
							</div>

							{/* Service Title */}
							<h3 className="text-center text-base font-semibold text-[#3E4555]">
								{service.subtitle || "Service"}
							</h3>
						</div>
					))}
				</div>
			</div>
		</section>
	)
}

export default SectionServicesWidget
