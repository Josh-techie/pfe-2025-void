import { Link } from "@/ui"
import { useMenu } from "@vactorynext/core/hooks"

export const config = {
	id: "custom_dynamic_fields:footer",
}

const FooterBlock = ({ data }) => {
	// Get menu machine name from backend data - like getting the right map for our souk
	const menuName = data?.extra_field?.use_menu || "footer"

	// Fetch menu using the hook - like asking the guide for the best route
	const footerMenu = useMenu(menuName)

	// Extract ALL data from backend - no hardcoding like a proper merchant!
	const {
		copyrights, // Pure backend data - no fallbacks
		signateur,
	} = data?.extra_field || {}

	// Debug logs - like keeping our business records
	// console.log("Menu Name:", menuName)
	// console.log("Footer Menu Data:", footerMenu)
	// console.log("Backend Data:", data?.extra_field)

	// Error handling - What if our data supplier doesn't deliver?
	if (!footerMenu || footerMenu.length === 0) {
		console.warn("Footer menu is empty or failed to load")
		return (
			<footer className="w-full bg-white">
				<div className="mx-auto max-w-7xl px-6 py-8 lg:px-8">
					<p className="text-center text-sm text-gray-500">
						Footer content is currently unavailable
					</p>
				</div>
			</footer>
		)
	}

	return (
		<footer className="w-full bg-white">
			<div className="mx-auto max-w-7xl px-6 py-8 lg:px-8 lg:py-12">
				{/* Menu Section with YouTube icon inline */}
				<div className="flex items-start gap-8">
					{/* YouTube Icon */}
					<Link
						href="https://www.youtube.com/channel/YOUR_CHANNEL_ID"
						className="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded bg-[#0178F6] transition-colors duration-200 hover:bg-blue-600"
						target="_blank"
						rel="noopener noreferrer"
					>
						<svg className="h-5 w-5 text-white" viewBox="0 0 24 24" fill="currentColor">
							<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
						</svg>
					</Link>

					{/* Navigation Menu */}
					<div className="flex flex-1 flex-wrap gap-8">
						{footerMenu.map((item, idx) => (
							<Link
								key={item.id || idx}
								href={item.url}
								className="text-base font-medium text-gray-900 transition-colors hover:text-[#0178F6]"
							>
								{item.title.trim()}
							</Link>
						))}
					</div>
				</div>

				{/* Bottom Border */}
				<div className="my-8 border-t border-gray-200" />

				{/* Bottom Section: Copyright and Signature */}
				<div className="flex flex-col space-y-4 lg:flex-row lg:items-center lg:justify-between lg:space-y-0">
					{/* Copyright Text - directly from backend */}
					<div className="text-center lg:text-left">
						{copyrights && (
							<p className="text-sm font-medium text-[#0178F6]">{copyrights}</p>
						)}
					</div>

					{/* Signature Section - like the craftsman's mark */}
					{signateur?.value?.["#text"] && (
						<div className="text-center lg:text-right">
							<div className="flex items-center justify-center space-x-2 lg:justify-end">
								<div
									className="text-sm text-[#0178F6]"
									dangerouslySetInnerHTML={{
										__html: signateur.value["#text"]
											.replace(/&nbsp;/g, " ") // Clean HTML spaces
											.replace(/<p>/g, "") // Remove p tags completely
											.replace(/<\/p>/g, "")
											.replace(/\n/g, "") // Remove line breaks
											.trim(),
									}}
								/>
								{/* VOID Badge - like the quality seal */}
								<span className="rounded bg-[#0178F6] px-2 py-0.5 text-xs font-bold text-white">
									VOID
								</span>
							</div>
						</div>
					)}
				</div>
			</div>
		</footer>
	)
}

export default FooterBlock
