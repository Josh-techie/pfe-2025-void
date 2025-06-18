export const config = {
	id: "custom_dynamic_fields:votre-satisfaction",
}

const SatisfactionSection = ({ data }) => {
	const content = data?.components?.[0] || {}

	return (
		<section className="bg-white py-16 lg:py-24">
			<div className="mx-auto max-w-7xl px-6 lg:px-8">
				<div className="mx-auto max-w-4xl">
					{/* Title with inline blue line */}
					<div className="mb-8 flex items-center">
						<div className="mr-6 h-0.5 w-12 bg-[#027CFF]"></div>
						<h2 className="text-3xl font-bold text-[#0B1F51] lg:text-4xl">
							{content.title || "VOTRE SATISFACTION, NOTRE PASSION"}
						</h2>
					</div>

					{/* Description with left alignment and padding */}
					<div className="pl-0 lg:pl-[4.5rem]">
						{" "}
						{/* Add padding on larger screens to align with title text */}
						<p className="mb-10 text-lg leading-relaxed text-gray-600">
							{content.description ||
								"Découvrez Capital Azur, la première banque 100% Digitale en Afrique et oubliez la paperasse et les frais cachés. Avec tous nos outils dédiés aux besoins de tous nos clients (Particuliers, Entreprises, Corporate), Nous vous accompagnons chaque jour pour réaliser vos projets de vie."}
						</p>
						{/* CTA Button with specified colors */}
						{content.link?.url && (
							<a
								href={content.link?.url}
								className="inline-flex items-center rounded-md bg-[#027CFF] px-8 py-3 text-base font-semibold text-white transition hover:bg-[rgb(1,99,203)]"
							>
								{content.link?.title || "A PROPOS DE NOUS"}
							</a>
						)}
					</div>
				</div>
			</div>
		</section>
	)
}

export default SatisfactionSection
