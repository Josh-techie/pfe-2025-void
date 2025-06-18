import { useState, useEffect, Fragment } from "react"
import { Dialog as HeadlessDialog, Menu, Transition } from "@headlessui/react"
import Image from "next/image"
import LockIcon from "../../../../icons/lock.svg"
import ChevronDownIcon from "../../../../icons/chevron-down.svg"
import MenuIcon from "../../../../icons/burger-menu.svg"
import CloseIcon from "../../../../icons/close.svg"
import { Link } from "@/ui"

export const config = {
	id: "custom_dynamic_fields:header",
}

const Header = ({ data }) => {
	// Destructure all needed values from data
	const logoUrl = data?.components?.[0]?.logo?.[0]?._default
	const logoLink = data?.components?.[0]?.logo_link?.url || "/"
	const logoAlt = data?.components?.[0]?.logo?.[0]?.meta?.alt || "Logo"
	const logoWidth = parseInt(data?.components?.[0]?.logo?.[0]?.meta?.width || "216")
	const logoHeight = parseInt(data?.components?.[0]?.logo?.[0]?.meta?.height || "128")

	// Get banque digitale data
	const banqueDigitaleText = data?.extra_field?.banque_digitale_text
	const banqueDigitaleLink = data?.extra_field?.banque_digitale_link?.url

	// Navigation items from menu
	const navigation = [
		{ name: "NOS PRODUITS", href: "/produits-services" },
		{ name: "NOUS CONNAÎTRE", href: "/nous-connaitre" },
		{ name: "NEWS", href: "/news" },
		{ name: "RECHERCHE", href: "/recherche" },
	]

	const [mobileMenuOpen, setMobileMenuOpen] = useState(false)
	const [currentLang, setCurrentLang] = useState("FR")
	const [mounted, setMounted] = useState(false)

	useEffect(() => {
		const storedLang = localStorage.getItem("language") || "FR"
		setCurrentLang(storedLang)
		setMounted(true)
	}, [])

	if (!data) return null

	return (
		<header className="sticky top-0 z-50 w-full bg-white shadow-sm">
			<div className="h-24 w-full bg-white">
				<nav className="relative mx-auto flex h-full max-w-7xl items-center justify-between px-6 lg:px-8">
					{/* Logo */}
					<div className="flex items-center lg:flex-1">
						<a href={logoLink} className="-m-1.5 flex items-center p-1.5">
							<span className="sr-only">Capital Azur</span>
							<Image
								src={logoUrl}
								alt={logoAlt}
								width={logoWidth}
								height={logoHeight}
								className="h-16 w-auto object-contain" // Increased height from h-12 to h-14
								priority
							/>
						</a>
					</div>

					{/* Desktop Navigation */}
					<div className="hidden lg:flex lg:gap-x-8">
						{navigation.map((item) => (
							<a
								key={item.name}
								href={item.href}
								className="text-sm font-medium text-gray-900 transition-colors hover:text-blue-600"
							>
								{item.name}
							</a>
						))}
					</div>

					{/* Right section - Banque Digitale & Language */}
					<div className="flex flex-1 items-center justify-end gap-x-4">
						{/* Desktop version */}
						<a
							href={banqueDigitaleLink}
							className="hidden items-center gap-2 whitespace-nowrap rounded-lg bg-[#0B1F51] px-4 py-2.5 text-sm font-semibold text-white lg:inline-flex"
						>
							BANQUE DIGITALE
							<Image
								src={LockIcon}
								alt=""
								className="h-4 w-4 flex-shrink-0 invert" // Added invert class to make icon white
								width={16}
								height={16}
							/>
						</a>

						{mounted && (
							<Menu as="div" className="relative hidden text-left lg:inline-block">
								<Menu.Button className="inline-flex items-center gap-2 whitespace-nowrap rounded-md border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 shadow-md transition-colors hover:bg-gray-200">
									{currentLang}
									<Image
										src={ChevronDownIcon}
										alt=""
										className="h-4 w-4 flex-shrink-0"
										width={16}
										height={16}
									/>
								</Menu.Button>

								<Transition
									as={Fragment}
									enter="transition ease-out duration-100"
									enterFrom="transform opacity-0 scale-95"
									enterTo="transform opacity-100 scale-100"
									leave="transition ease-in duration-75"
									leaveFrom="transform opacity-100 scale-100"
									leaveTo="transform opacity-0 scale-95"
								>
									<Menu.Items className="absolute right-0 mt-2 w-24 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-gray-200 focus:outline-none">
										<div className="py-1">
											<Menu.Item>
												{({ active }) => (
													<button
														onClick={() => {
															setCurrentLang("FR")
															localStorage.setItem("language", "FR")
														}}
														className={`${
															active ? "bg-gray-100 text-blue-600" : "text-gray-700"
														} block w-full px-4 py-2 text-left text-sm font-medium`}
													>
														FR
													</button>
												)}
											</Menu.Item>
											<Menu.Item>
												{({ active }) => (
													<button
														onClick={() => {
															setCurrentLang("EN")
															localStorage.setItem("language", "EN")
														}}
														className={`${
															active ? "bg-gray-100 text-blue-600" : "text-gray-700"
														} block w-full px-4 py-2 text-left text-sm font-medium`}
													>
														EN
													</button>
												)}
											</Menu.Item>
										</div>
									</Menu.Items>
								</Transition>
							</Menu>
						)}
					</div>

					{/* Mobile menu button */}
					<div className="flex lg:hidden">
						<button
							type="button"
							onClick={() => setMobileMenuOpen(true)}
							className="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 transition-colors hover:bg-gray-100"
						>
							<span className="sr-only">Open main menu</span>
							<Image
								src={MenuIcon}
								alt=""
								className="h-6 w-6 flex-shrink-0"
								width={24}
								height={24}
							/>
						</button>
					</div>
				</nav>
			</div>

			{/* Mobile menu */}
			<HeadlessDialog
				as="div"
				className="lg:hidden"
				open={mobileMenuOpen}
				onClose={setMobileMenuOpen}
			>
				<div className="fixed inset-0 z-50 bg-black/30" aria-hidden="true" />
				<HeadlessDialog.Panel className="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white">
					<div className="flex items-center justify-between p-6">
						<Link href={logoLink} className="-m-1.5 p-1.5">
							<span className="sr-only">Capital Azur</span>
							<div className="relative h-10">
								<Image
									src={logoUrl}
									alt={logoAlt}
									className="h-full w-auto object-contain"
									width={logoWidth}
									height={logoHeight}
									priority
								/>
							</div>
						</Link>
						<button
							type="button"
							className="-m-2.5 rounded-md p-2.5 text-gray-700 transition-colors hover:bg-gray-100"
							onClick={() => setMobileMenuOpen(false)}
						>
							<span className="sr-only">Close menu</span>
							<Image src={CloseIcon} alt="" className="h-6 w-6" width={24} height={24} />
						</button>
					</div>
					<div className="mt-6 flow-root px-6">
						<div className="-my-6 divide-y divide-gray-500/10">
							<div className="space-y-2 py-6">
								{navigation.map((item) => (
									<Link
										key={item.name}
										href={item.href}
										className="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold text-gray-900 transition-colors hover:bg-gray-50"
									>
										{item.name}
									</Link>
								))}
							</div>
							<div className="py-6">
								<Link
									href={banqueDigitaleLink}
									className="flex w-full items-center justify-center gap-2 rounded-lg bg-[#0B1F51] px-3 py-2.5 text-base font-semibold text-white transition-all duration-200 hover:bg-white hover:text-[#0178F6]"
								>
									{banqueDigitaleText}
									<Image
										src={LockIcon}
										alt=""
										className="h-4 w-4 invert transition-all duration-200 group-hover:invert-0"
										width={16}
										height={16}
									/>
								</Link>
								{mounted && (
									<Menu as="div" className="relative mt-4 w-full">
										<Menu.Button className="flex w-full items-center justify-center gap-2 rounded-lg bg-gray-100 px-3 py-2.5 text-base font-semibold text-gray-900 transition-colors hover:bg-gray-200">
											{currentLang}
											<Image
												src={ChevronDownIcon}
												alt=""
												className="h-4 w-4"
												width={16}
												height={16}
											/>
										</Menu.Button>
										<Transition
											as={Fragment}
											enter="transition ease-out duration-100"
											enterFrom="transform opacity-0 scale-95"
											enterTo="transform opacity-100 scale-100"
											leave="transition ease-in duration-75"
											leaveFrom="transform opacity-100 scale-100"
											leaveTo="transform opacity-0 scale-95"
										>
											<Menu.Items className="absolute right-0 mt-2 w-full origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
												<div className="py-1">
													<Menu.Item>
														{({ active }) => (
															<button
																onClick={() => {
																	setCurrentLang("FR")
																	localStorage.setItem("language", "FR")
																}}
																className={`${
																	active ? "bg-gray-100 text-gray-900" : "text-gray-700"
																} block w-full px-4 py-2 text-left text-sm`}
															>
																FR
															</button>
														)}
													</Menu.Item>
													<Menu.Item>
														{({ active }) => (
															<button
																onClick={() => {
																	setCurrentLang("EN")
																	localStorage.setItem("language", "EN")
																}}
																className={`${
																	active ? "bg-gray-100 text-gray-900" : "text-gray-700"
																} block w-full px-4 py-2 text-left text-sm`}
															>
																EN
															</button>
														)}
													</Menu.Item>
												</div>
											</Menu.Items>
										</Transition>
									</Menu>
								)}
							</div>
						</div>
					</div>
				</HeadlessDialog.Panel>
			</HeadlessDialog>
		</header>
	)
}

export default Header
